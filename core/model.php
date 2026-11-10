<?php

class Model
{
    private $db;
    private $conn;

    public function __construct()
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $hostname = strtolower(explode(':', $host)[0]);

        // Detect environment
        $isOffline = in_array($hostname, ['localhost', '127.0.0.1', '192.168.1.8'], true);

        // Initialize database connection
        $this->db = new Database();

        $this->conn = $isOffline ? $this->db->offline_connect() : $this->db->online_connect();
    }

    public function findUserByUsername(string $username): ?array
    {
        return $this->db->table('users')->where('username', '=', $username)->first();
    }

    public function findStudentById(int $id): ?array
    {
        return $this->db->table('students')->where('id', '=', $id)->first();
    }
    
    public function findStudentByStudentId(string $studentId): ?array
    {
        return $this->db->table('students')->where('student_id', '=', $studentId)->first();
    }

    public function findUserByUserId(string $userId): ?array
    {
        return $this->db->table('users')->where('id', '=', $userId)->first();
    }

    public function updateStudentData(array $data, int $id): int
    {
        return $this->db->table('students')->where('id', $id)->update($data);
    }
}