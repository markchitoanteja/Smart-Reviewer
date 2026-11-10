<?php
require_once __DIR__ . '/utils.php';

class Server
{
    private Model $model;
    private array $responseData;

    public function __construct()
    {
        $this->model = new Model();
        $this->responseData = [];

        // Handle incoming requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // LOGIN
            if (($_POST['action'] ?? '') === 'login') {
                $this->handleLogin();
            } elseif (($_POST['action'] ?? '') === 'logout') {
                $this->handleLogout();
            } elseif (($_POST['action'] ?? '') === 'update_profile') {
                $this->handleUpdateProfile();
            } else {
                jsonResponse(['error' => 'Invalid action'], 400);
            }
        } else {
            jsonResponse(['error' => 'Invalid request method'], 405);
        }
    }

    private function handleLogin()
    {
        $studentId = trim($_POST['student_id'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = filter_var($_POST['remember'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $responseData = ['success' => false];

        // Find user using username first (admin login).
        $user = $this->model->findUserByUsername($studentId);

        if ($user) {
            // ADMIN LOGIN
            if ($user['role'] === 'admin' && $user['status'] === 'active' && password_verify($password, $user['password_hash'])) {
                // session_regenerate_id(true);

                // $_SESSION['user_id'] = (int) $user['id'];
                // $_SESSION['userProfile'] = [
                //     'user' => $user,
                //     'student' => null,
                // ];

                // if ($remember) {
                //     createRememberToken((int) $user['id']);
                // } else {
                //     // Remove the current browser's Remember Me token.
                //     revokeRememberTokens((int) $user['id']);
                // }

                $responseData = ['success' => false];
            }
        } else {
            // STUDENT LOGIN
            $student = $this->model->findStudentByStudentId($studentId);

            if ($student) {
                $studentUserData = $this->model->findUserByUserId($student['user_id']);

                if ($studentUserData && $studentUserData['role'] === 'student' && $studentUserData['status'] === 'active' && password_verify($password, $studentUserData['password_hash'])) {
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = (int) $studentUserData['id'];

                    $_SESSION['userProfile'] = [
                        'user' => $studentUserData,
                        'student' => $student,
                    ];

                    if ($remember) {
                        createRememberToken((int) $studentUserData['id']);
                    } else {
                        // Remove the current browser's Remember Me token.
                        revokeRememberTokens((int) $studentUserData['id']);
                    }

                    $responseData = ['success' => true];
                }
            }
        }

        jsonResponse($responseData);
    }

    private function handleUpdateProfile()
    {
        try {
            // Retrieve form inputs.
            $id = trim($_POST['id'] ?? '');
            $first_name = trim($_POST['first_name'] ?? '');
            $middle_name = trim($_POST['middle_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $date_of_birth = trim($_POST['date_of_birth'] ?? '');
            $sex = trim($_POST['sex'] ?? '');

            // Prepare student data.
            $data = [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'date_of_birth' => $date_of_birth,
                'sex' => $sex,
            ];

            // Upload profile image only if a new image is selected.
            if (
                isset($_FILES['image']) &&
                $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $imageName = uploadImage('image');

                if ($imageName !== null) {
                    $data['image'] = $imageName;
                }
            }

            // Update student information.
            $this->model->updateStudentData($data, (int) $id);

            // Retrieve updated student information.
            $student = $this->model->findStudentById((int) $id);

            // Update the student session while preserving the logged-in user data.
            $_SESSION['userProfile'] = [
                'user' => $_SESSION['userProfile']['user'],
                'student' => $student
            ];

            setFlashMessage('main_message', [
                'title' => 'Changes Saved!',
                'type' => 'success',
                'text' => 'Your profile has been updated successfully.'
            ]);

            $responseData = ['success' => true];

        } catch (RuntimeException $e) {
            $responseData = [
                'message' => $e->getMessage(),
                'success' => false
            ];
        }

        jsonResponse($responseData);
    }

    private function handleLogout()
    {
        // 1. Get the authenticated user ID before clearing the session.
        $userId = $_SESSION['user_id'] ?? null;

        // 2. Revoke Remember Me tokens and clear the Remember Me cookie.
        revokeRememberTokens($userId);

        // 3. Clear all existing session data.
        $_SESSION = [];

        // 4. Regenerate the session ID to invalidate the old session.
        session_regenerate_id(true);

        // 5. Set the logout feedback in the new session.
        setFlashMessage('login_message', [
            'title' => 'Logged Out',
            'type' => 'info',
            'text' => 'You have been logged out successfully.'
        ]);

        // 6. Return the response.
        jsonResponse(['success' => true]);
    }
}

new Server();