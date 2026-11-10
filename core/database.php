<?php

class Database
{
    private ?mysqli $conn = null;

    private ?string $tableName = null;
    private string $queryType = 'SELECT';

    private array $columns = ['*'];
    private array $conditions = [];
    private array $bindings = [];
    private array $orders = [];
    private array $groups = [];
    private array $havings = [];

    private ?int $limitValue = null;
    private ?int $offsetValue = null;

    public function __construct()
    {
        $host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);

        $offlineHosts = [
            'localhost',
            '127.0.0.1',
            '192.168.1.8'
        ];

        if (in_array($host, $offlineHosts, true)) {
            $this->offline_connect();
        } elseif ($host === 'smart-reviewer.site.je') {
            $this->online_connect();
        } else {
            throw new RuntimeException('Unrecognized application host.');
        }
    }

    // ==========================================
    // DATABASE CONNECTIONS
    // ==========================================

    public function offline_connect(): mysqli
    {
        return $this->connect(
            env('OFFLINE_DB_HOST'),
            env('OFFLINE_DB_USERNAME'),
            env('OFFLINE_DB_PASSWORD'),
            env('OFFLINE_DB_NAME')
        );
    }

    public function online_connect(): mysqli
    {
        return $this->connect(
            env('ONLINE_DB_HOST'),
            env('ONLINE_DB_USERNAME'),
            env('ONLINE_DB_PASSWORD'),
            env('ONLINE_DB_NAME')
        );
    }

    private function connect(
        string $host,
        string $username,
        string $password,
        string $database
    ): mysqli {
        $this->conn = new mysqli(
            $host,
            $username,
            $password,
            $database
        );

        if ($this->conn->connect_error) {
            throw new RuntimeException(
                'Database connection failed: ' . $this->conn->connect_error
            );
        }

        $this->conn->set_charset('utf8mb4');

        return $this->conn;
    }

    public function connection(): mysqli
    {
        if (!$this->conn) {
            throw new RuntimeException('Database is not connected.');
        }

        return $this->conn;
    }

    // ==========================================
    // QUERY BUILDER INITIALIZATION
    // ==========================================

    public function table(string $table): self
    {
        $this->resetQuery();

        $this->tableName = $this->quoteIdentifier($table);

        return $this;
    }

    private function resetQuery(): void
    {
        $this->tableName = null;
        $this->queryType = 'SELECT';

        $this->columns = ['*'];
        $this->conditions = [];
        $this->bindings = [];
        $this->orders = [];
        $this->groups = [];
        $this->havings = [];

        $this->limitValue = null;
        $this->offsetValue = null;
    }

    private function quoteIdentifier(string $identifier): string
    {
        $parts = explode('.', $identifier);

        foreach ($parts as &$part) {
            if ($part === '*') {
                continue;
            }

            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $part)) {
                throw new InvalidArgumentException(
                    "Invalid SQL identifier: {$identifier}"
                );
            }

            $part = "`{$part}`";
        }

        return implode('.', $parts);
    }

    private function ensureTable(): void
    {
        if (!$this->tableName) {
            throw new RuntimeException('Please specify a table first using table().');
        }
    }

    // ==========================================
    // SELECT
    // ==========================================

    public function select(string ...$columns): self
    {
        $this->queryType = 'SELECT';

        $this->columns = empty($columns) ? ['*'] : array_map(
            fn($column) => $column === '*'
                ? '*'
                : $this->quoteIdentifier($column),
            $columns
        );

        return $this;
    }

    // ==========================================
    // WHERE CONDITIONS
    // ==========================================

    public function where(
        string $column,
        mixed $operator,
        mixed $value = null
    ): self {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        return $this->addWhere($column, $operator, $value, 'AND');
    }

    public function orWhere(
        string $column,
        mixed $operator,
        mixed $value = null
    ): self {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        return $this->addWhere($column, $operator, $value, 'OR');
    }

    private function addWhere(
        string $column,
        string $operator,
        mixed $value,
        string $boolean
    ): self {
        $this->ensureTable();

        $column = $this->quoteIdentifier($column);
        $operator = strtoupper(trim($operator));

        $allowedOperators = [
            '=',
            '!=',
            '<>',
            '>',
            '<',
            '>=',
            '<=',
            'LIKE',
            'NOT LIKE'
        ];

        if ($value === null && in_array($operator, ['=', 'IS'], true)) {
            $this->conditions[] = [
                'boolean' => $boolean,
                'sql' => "{$column} IS NULL",
                'bindings' => []
            ];

            return $this;
        }

        if ($value === null && in_array($operator, ['!=', '<>', 'IS NOT'], true)) {
            $this->conditions[] = [
                'boolean' => $boolean,
                'sql' => "{$column} IS NOT NULL",
                'bindings' => []
            ];

            return $this;
        }

        if (!in_array($operator, $allowedOperators, true)) {
            throw new InvalidArgumentException('Invalid WHERE operator.');
        }

        $this->conditions[] = [
            'boolean' => $boolean,
            'sql' => "{$column} {$operator} ?",
            'bindings' => [$value]
        ];

        return $this;
    }

    public function whereIn(string $column, array $values): self
    {
        if (empty($values)) {
            $this->conditions[] = [
                'boolean' => 'AND',
                'sql' => '1 = 0',
                'bindings' => []
            ];

            return $this;
        }

        $column = $this->quoteIdentifier($column);
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        $this->conditions[] = [
            'boolean' => 'AND',
            'sql' => "{$column} IN ({$placeholders})",
            'bindings' => array_values($values)
        ];

        return $this;
    }

    public function whereNull(string $column): self
    {
        return $this->where($column, 'IS', null);
    }

    public function whereNotNull(string $column): self
    {
        return $this->where($column, 'IS NOT', null);
    }

    private function buildWhere(): string
    {
        if (empty($this->conditions)) {
            return '';
        }

        $sql = ' WHERE ';

        foreach ($this->conditions as $index => $condition) {
            if ($index > 0) {
                $sql .= ' ' . $condition['boolean'] . ' ';
            }

            $sql .= $condition['sql'];

            $this->bindings = array_merge(
                $this->bindings,
                $condition['bindings']
            );
        }

        return $sql;
    }

    // ==========================================
    // ORDER BY / GROUP BY / HAVING
    // ==========================================

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction);

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Invalid order direction.');
        }

        $this->orders[] = $this->quoteIdentifier($column) . " {$direction}";

        return $this;
    }

    public function groupBy(string ...$columns): self
    {
        foreach ($columns as $column) {
            $this->groups[] = $this->quoteIdentifier($column);
        }

        return $this;
    }

    public function having(string $column, string $operator, mixed $value): self
    {
        $allowed = ['=', '!=', '>', '<', '>=', '<=', 'LIKE'];

        $operator = strtoupper($operator);

        if (!in_array($operator, $allowed, true)) {
            throw new InvalidArgumentException('Invalid HAVING operator.');
        }

        $this->havings[] = [
            'sql' => $this->quoteIdentifier($column) . " {$operator} ?",
            'value' => $value
        ];

        return $this;
    }

    public function limit(int $limit): self
    {
        if ($limit < 0) {
            throw new InvalidArgumentException('Limit cannot be negative.');
        }

        $this->limitValue = $limit;

        return $this;
    }

    public function offset(int $offset): self
    {
        if ($offset < 0) {
            throw new InvalidArgumentException('Offset cannot be negative.');
        }

        $this->offsetValue = $offset;

        return $this;
    }

    // ==========================================
    // INSERT
    // ==========================================

    public function insert(array $data): int
    {
        $this->ensureTable();

        if (empty($data)) {
            throw new InvalidArgumentException('Insert data cannot be empty.');
        }

        $columns = array_keys($data);

        $columnList = implode(
            ', ',
            array_map(fn($column) => $this->quoteIdentifier($column), $columns)
        );

        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->tableName} ({$columnList})
                VALUES ({$placeholders})";

        $result = $this->execute($sql, array_values($data));

        $insertId = $result['insert_id'];

        $this->resetQuery();

        return $insertId;
    }

    // ==========================================
    // UPDATE
    // ==========================================

    public function update(array $data): int
    {
        $this->ensureTable();

        if (empty($data)) {
            throw new InvalidArgumentException('Update data cannot be empty.');
        }

        if (empty($this->conditions)) {
            throw new RuntimeException(
                'UPDATE requires at least one WHERE condition.'
            );
        }

        $set = [];

        $values = [];

        foreach ($data as $column => $value) {
            $set[] = $this->quoteIdentifier($column) . ' = ?';
            $values[] = $value;
        }

        $this->bindings = [];

        $where = $this->buildWhere();

        $sql = "UPDATE {$this->tableName}
                SET " . implode(', ', $set) . $where;

        $values = array_merge($values, $this->bindings);

        $result = $this->execute($sql, $values);

        $affected = $result['affected_rows'];

        $this->resetQuery();

        return $affected;
    }

    // ==========================================
    // DELETE
    // ==========================================

    public function delete(): int
    {
        $this->ensureTable();

        if (empty($this->conditions)) {
            throw new RuntimeException(
                'DELETE requires at least one WHERE condition.'
            );
        }

        $this->bindings = [];

        $where = $this->buildWhere();

        $sql = "DELETE FROM {$this->tableName}{$where}";

        $result = $this->execute($sql, $this->bindings);

        $affected = $result['affected_rows'];

        $this->resetQuery();

        return $affected;
    }

    // ==========================================
    // GET / FIRST / COUNT
    // ==========================================

    public function get(): array
    {
        $this->ensureTable();

        $this->bindings = [];

        $columns = implode(', ', $this->columns);

        $sql = "SELECT {$columns} FROM {$this->tableName}";

        $sql .= $this->buildWhere();

        if (!empty($this->groups)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groups);
        }

        if (!empty($this->havings)) {
            $havingSql = [];

            foreach ($this->havings as $having) {
                $havingSql[] = $having['sql'];
                $this->bindings[] = $having['value'];
            }

            $sql .= ' HAVING ' . implode(' AND ', $havingSql);
        }

        if (!empty($this->orders)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orders);
        }

        if ($this->limitValue !== null) {
            $sql .= ' LIMIT ' . $this->limitValue;
        }

        if ($this->offsetValue !== null) {
            if ($this->limitValue === null) {
                $sql .= ' LIMIT 18446744073709551615';
            }

            $sql .= ' OFFSET ' . $this->offsetValue;
        }

        $result = $this->execute($sql, $this->bindings);

        $this->resetQuery();

        return $result['data'];
    }

    public function first(): ?array
    {
        $this->limit(1);

        $result = $this->get();

        return $result[0] ?? null;
    }

    public function count(string $column = '*'): int
    {
        $this->columns = [
            $column === '*' ? 'COUNT(*) AS total' :
            'COUNT(' . $this->quoteIdentifier($column) . ') AS total'
        ];

        $result = $this->get();

        return (int) ($result[0]['total'] ?? 0);
    }

    // ==========================================
    // CUSTOM SQL
    // ==========================================

    public function query(string $sql, array $params = []): array|int
    {
        $result = $this->execute($sql, $params);

        if ($result['data'] !== null) {
            return $result['data'];
        }

        return $result['affected_rows'];
    }

    public function raw(string $sql, array $params = []): array|int
    {
        return $this->query($sql, $params);
    }

    // ==========================================
    // STATEMENT EXECUTION
    // ==========================================

    private function execute(string $sql, array $params = []): array
    {
        if (!$this->conn) {
            throw new RuntimeException('Database is not connected.');
        }

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException(
                'SQL preparation failed: ' . $this->conn->error
            );
        }

        try {
            if (!empty($params)) {
                $types = '';

                foreach ($params as $value) {
                    $types .= match (true) {
                        is_int($value), is_bool($value) => 'i',
                        is_float($value) => 'd',
                        default => 's'
                    };
                }

                $references = [];

                foreach ($params as $key => &$value) {
                    $references[$key] = &$value;
                }

                unset($value);

                $bindArguments = array_merge([$types], $references);

                if (!$stmt->bind_param(...$bindArguments)) {
                    throw new RuntimeException(
                        'Parameter binding failed: ' . $stmt->error
                    );
                }
            }

            if (!$stmt->execute()) {
                throw new RuntimeException(
                    'SQL execution failed: ' . $stmt->error
                );
            }

            $data = null;

            if ($stmt->field_count > 0) {
                $result = $stmt->get_result();

                if ($result === false) {
                    throw new RuntimeException(
                        'Unable to retrieve query results.'
                    );
                }

                $data = $result->fetch_all(MYSQLI_ASSOC);
            }

            return [
                'data' => $data,
                'affected_rows' => $stmt->affected_rows,
                'insert_id' => $stmt->insert_id
            ];

        } finally {
            $stmt->close();
        }
    }

    // ==========================================
    // REMEMBER ME
    // ==========================================

    /**
     * Create a Remember Me token.
     */
    public function createRememberToken(int $userId, string $selector, string $tokenHash, string $expiresAt): int
    {
        return $this->table('remember_tokens')->insert([
            'user_id' => $userId,
            'selector' => $selector,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * Find a Remember Me token by selector.
     */
    public function findRememberToken(string $selector): ?array
    {
        return $this->table('remember_tokens')->where('selector', $selector)->first();
    }

    /**
     * Delete a Remember Me token by selector.
     */
    public function deleteRememberToken(string $selector): int
    {
        return $this->table('remember_tokens')->where('selector', $selector)->delete();
    }

    /**
     * Delete all Remember Me tokens belonging to a user.
     */
    public function deleteUserRememberTokens(int $userId): int
    {
        return $this->table('remember_tokens')->where('user_id', $userId)->delete();
    }

    /**
     * Remove expired Remember Me tokens.
     */
    public function deleteExpiredRememberTokens(): int
    {
        return $this->table('remember_tokens')->where('expires_at', '<=', date('Y-m-d H:i:s'))->delete();
    }
}
