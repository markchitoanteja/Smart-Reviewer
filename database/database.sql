-- Smart Reviewer Application
-- Database: smart_reviewer_db
-- Compatible with MySQL 8+ / MariaDB 10.4+ (XAMPP)
-- Demo accounts all use password: password
-- IMPORTANT: Change demo passwords before deploying this application publicly.
-- PHP login should verify passwords using password_verify(), not compare hashes directly.

CREATE DATABASE IF NOT EXISTS smart_reviewer_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE smart_reviewer_db;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS quiz_answers;
DROP TABLE IF EXISTS quiz_attempts;
DROP TABLE IF EXISTS question_options;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS review_materials;
DROP TABLE IF EXISTS topics;
DROP TABLE IF EXISTS subjects;
DROP TABLE IF EXISTS student_profiles;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(60) NOT NULL,
    middle_name VARCHAR(60) NULL,
    last_name VARCHAR(60) NOT NULL,
    role ENUM('ADMIN', 'STUDENT') NOT NULL DEFAULT 'STUDENT',
    account_status ENUM('ACTIVE', 'INACTIVE', 'SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
    last_login_at DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE student_profiles (
    student_profile_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    student_number VARCHAR(30) NOT NULL UNIQUE,
    grade_level TINYINT UNSIGNED NOT NULL DEFAULT 11,
    strand VARCHAR(30) NOT NULL DEFAULT 'TVL-ICT',
    section VARCHAR(80) NOT NULL,
    school_year VARCHAR(9) NOT NULL DEFAULT '2026-2027',
    enrollment_status ENUM('ENROLLED', 'TRANSFERRED', 'GRADUATED', 'INACTIVE') NOT NULL DEFAULT 'ENROLLED',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_student_profile_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE subjects (
    subject_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(120) NOT NULL UNIQUE,
    subject_code VARCHAR(30) NULL UNIQUE,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE topics (
    topic_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject_id INT UNSIGNED NOT NULL,
    topic_title VARCHAR(180) NOT NULL,
    description TEXT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    difficulty ENUM('BEGINNER', 'INTERMEDIATE', 'ADVANCED') NOT NULL DEFAULT 'BEGINNER',
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_topics_subject FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE,
    UNIQUE KEY uq_topic_subject_title (subject_id, topic_title)
) ENGINE=InnoDB;

CREATE TABLE review_materials (
    material_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    topic_id INT UNSIGNED NOT NULL,
    title VARCHAR(180) NOT NULL,
    content LONGTEXT NOT NULL,
    material_type ENUM('LESSON', 'SUMMARY', 'STUDY_GUIDE') NOT NULL DEFAULT 'LESSON',
    estimated_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 10,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_material_topic FOREIGN KEY (topic_id) REFERENCES topics(topic_id) ON DELETE CASCADE,
    CONSTRAINT fk_material_creator FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE quizzes (
    quiz_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    topic_id INT UNSIGNED NOT NULL,
    quiz_title VARCHAR(180) NOT NULL,
    instructions TEXT NULL,
    time_limit_minutes SMALLINT UNSIGNED NULL,
    passing_score DECIMAL(5,2) NOT NULL DEFAULT 75.00,
    max_attempts TINYINT UNSIGNED NOT NULL DEFAULT 3,
    status ENUM('DRAFT', 'PUBLISHED', 'ARCHIVED') NOT NULL DEFAULT 'DRAFT',
    available_from DATETIME NULL,
    available_until DATETIME NULL,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_quiz_topic FOREIGN KEY (topic_id) REFERENCES topics(topic_id) ON DELETE CASCADE,
    CONSTRAINT fk_quiz_creator FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE questions (
    question_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT UNSIGNED NOT NULL,
    question_text TEXT NOT NULL,
    explanation TEXT NULL,
    points DECIMAL(6,2) NOT NULL DEFAULT 1.00,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    question_type ENUM('MULTIPLE_CHOICE') NOT NULL DEFAULT 'MULTIPLE_CHOICE',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_question_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE,
    UNIQUE KEY uq_question_order (quiz_id, sort_order)
) ENGINE=InnoDB;

CREATE TABLE question_options (
    option_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question_id INT UNSIGNED NOT NULL,
    option_label CHAR(1) NOT NULL,
    option_text TEXT NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT fk_option_question FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE,
    UNIQUE KEY uq_question_option_label (question_id, option_label)
) ENGINE=InnoDB;

CREATE TABLE quiz_attempts (
    attempt_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    quiz_id INT UNSIGNED NOT NULL,
    attempt_number TINYINT UNSIGNED NOT NULL DEFAULT 1,
    started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    submitted_at DATETIME NULL,
    score DECIMAL(7,2) NULL,
    total_points DECIMAL(7,2) NOT NULL DEFAULT 0.00,
    percentage DECIMAL(5,2) NULL,
    result_status ENUM('IN_PROGRESS', 'PASSED', 'FAILED', 'ABANDONED') NOT NULL DEFAULT 'IN_PROGRESS',
    CONSTRAINT fk_attempt_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT fk_attempt_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(quiz_id) ON DELETE CASCADE,
    UNIQUE KEY uq_user_quiz_attempt (user_id, quiz_id, attempt_number),
    INDEX idx_attempt_user_date (user_id, started_at),
    INDEX idx_attempt_quiz_status (quiz_id, result_status)
) ENGINE=InnoDB;

CREATE TABLE quiz_answers (
    answer_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    attempt_id BIGINT UNSIGNED NOT NULL,
    question_id INT UNSIGNED NOT NULL,
    selected_option_id INT UNSIGNED NULL,
    is_correct TINYINT(1) NULL,
    points_awarded DECIMAL(6,2) NOT NULL DEFAULT 0.00,
    answered_at DATETIME NULL,
    CONSTRAINT fk_answer_attempt FOREIGN KEY (attempt_id) REFERENCES quiz_attempts(attempt_id) ON DELETE CASCADE,
    CONSTRAINT fk_answer_question FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE,
    CONSTRAINT fk_answer_option FOREIGN KEY (selected_option_id) REFERENCES question_options(option_id) ON DELETE SET NULL,
    UNIQUE KEY uq_attempt_question (attempt_id, question_id)
) ENGINE=InnoDB;

-- Demo password hash is a bcrypt hash commonly used for the password "password".
-- Replace it with password_hash($password, PASSWORD_DEFAULT) for real accounts.
INSERT INTO users
(user_id, username, email, password_hash, first_name, middle_name, last_name, role, account_status)
VALUES
(1, 'admin', 'admin@smartreviewer.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/qi', 'System', NULL, 'Administrator', 'ADMIN', 'ACTIVE'),
(2, 'maria.santos', 'maria.santos@student.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/qi', 'Maria', 'Lopez', 'Santos', 'STUDENT', 'ACTIVE'),
(3, 'juan.dela.cruz', 'juan.delacruz@student.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/qi', 'Juan', 'Reyes', 'Dela Cruz', 'STUDENT', 'ACTIVE'),
(4, 'angelo.reyes', 'angelo.reyes@student.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/qi', 'Angelo', 'Garcia', 'Reyes', 'STUDENT', 'ACTIVE'),
(5, 'katrina.ramos', 'katrina.ramos@student.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/qi', 'Katrina', 'Mendoza', 'Ramos', 'STUDENT', 'ACTIVE'),
(6, 'patrick.mendoza', 'patrick.mendoza@student.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/qi', 'Patrick', 'Villanueva', 'Mendoza', 'STUDENT', 'ACTIVE');

INSERT INTO student_profiles
(user_id, student_number, grade_level, strand, section, school_year, enrollment_status)
VALUES
(2, '2026-11-001', 11, 'TVL-ICT', 'TechPro - A', '2026-2027', 'ENROLLED'),
(3, '2026-11-002', 11, 'TVL-ICT', 'TechPro - A', '2026-2027', 'ENROLLED'),
(4, '2026-11-003', 11, 'TVL-ICT', 'TechPro - A', '2026-2027', 'ENROLLED'),
(5, '2026-11-004', 11, 'TVL-ICT', 'TechPro - A', '2026-2027', 'ENROLLED'),
(6, '2026-11-005', 11, 'TVL-ICT', 'TechPro - A', '2026-2027', 'ENROLLED');

INSERT INTO subjects (subject_id, subject_name, subject_code, description)
VALUES
(1, 'Other subject', 'OTH-11', 'General review subject for the initial Smart Reviewer prototype. Lessons focus on practical digital literacy and responsible technology use.');

INSERT INTO topics (topic_id, subject_id, topic_title, description, sort_order, difficulty)
VALUES
(1, 1, 'Computer Fundamentals', 'Basic computer concepts, hardware, software, and common computer operations.', 1, 'BEGINNER'),
(2, 1, 'Internet Safety and Digital Citizenship', 'Safe browsing, privacy, respectful online behavior, and evaluating online information.', 2, 'BEGINNER'),
(3, 1, 'Productivity Tools and File Management', 'Documents, spreadsheets, file types, folder organization, and safe file handling.', 3, 'INTERMEDIATE');

INSERT INTO review_materials (material_id, topic_id, title, content, material_type, estimated_minutes, created_by)
VALUES
(1, 1, 'Introduction to Computer Fundamentals',
'## What is a computer?\nA computer is an electronic device that accepts data, processes it according to instructions, stores information, and produces output.\n\n## Main components\n- Input devices: keyboard, mouse, scanner, and microphone.\n- Processing: the CPU executes instructions and coordinates computer operations.\n- Output devices: monitor, printer, and speakers.\n- Storage: SSDs, hard drives, and flash drives keep files and programs.\n\n## Hardware and software\nHardware refers to physical components. Software refers to programs and instructions. An operating system, such as Windows or Linux, manages hardware and provides services for applications.\n\n## Remember\nRAM is temporary working memory; files stored on an SSD or hard drive remain after shutdown.',
'LESSON', 12, 1),
(2, 2, 'Internet Safety and Digital Citizenship',
'## Protect your accounts\nUse long, unique passwords and enable multi-factor authentication when available. Never share one-time passwords or verification codes.\n\n## Recognize phishing\nPhishing messages try to trick people into revealing credentials, sending money, or opening unsafe links. Check the sender and destination address carefully. When unsure, visit the official website directly.\n\n## Protect personal information\nThink before posting personal details, school schedules, addresses, or private photographs. Review privacy settings and ask permission before sharing another person''s information.\n\n## Be a responsible digital citizen\nCommunicate respectfully, credit sources, avoid cyberbullying, and verify claims before forwarding them.',
'STUDY_GUIDE', 15, 1),
(3, 3, 'Productivity Tools and File Management',
'## Organize your work\nCreate clear folders by subject or project and use descriptive filenames such as Research_Outline_v2.docx. Keep a backup of important work.\n\n## Common file types\n- .docx: word-processing document\n- .xlsx: spreadsheet workbook\n- .pptx: presentation\n- .pdf: portable document format\n- .jpg and .png: image files\n\n## Productivity tools\nWord processors are used to create documents, spreadsheets organize data and perform calculations, and presentation tools communicate ideas visually.\n\n## Good practice\nSave work regularly, verify the save location, use meaningful filenames, and avoid opening unexpected attachments.',
'LESSON', 14, 1);

INSERT INTO quizzes (quiz_id, topic_id, quiz_title, instructions, time_limit_minutes, passing_score, max_attempts, status, created_by)
VALUES
(1, 1, 'Computer Fundamentals: Quick Check', 'Choose the best answer for each question. Each question is worth one point.', 10, 75.00, 3, 'PUBLISHED', 1),
(2, 2, 'Internet Safety and Digital Citizenship', 'Read each situation carefully and choose the safest or most responsible action.', 12, 75.00, 3, 'PUBLISHED', 1),
(3, 3, 'Productivity Tools and File Management', 'Test your understanding of common file formats and good file-management habits.', 10, 75.00, 3, 'PUBLISHED', 1);

INSERT INTO questions (question_id, quiz_id, question_text, explanation, points, sort_order)
VALUES
(1, 1, 'Which component executes instructions and performs most processing tasks?', 'The CPU executes program instructions and performs arithmetic and logical operations.', 1, 1),
(2, 1, 'Which type of memory temporarily holds data and programs currently in use?', 'RAM is volatile working memory and usually loses its contents when power is removed.', 1, 2),
(3, 1, 'Which of the following is an input device?', 'A keyboard sends user input to the computer.', 1, 3),
(4, 1, 'Which statement best describes an operating system?', 'An operating system manages hardware resources and provides a platform for applications.', 1, 4),
(5, 1, 'Which storage device normally keeps files when the computer is turned off?', 'An SSD or hard drive provides non-volatile storage.', 1, 5),
(6, 2, 'You receive a message asking you to click a link and confirm your school account password immediately. What should you do?', 'Urgent credential requests may be phishing. Verify through an official channel and do not use suspicious links.', 1, 1),
(7, 2, 'Which is the strongest account-security practice?', 'Use unique passwords and enable multi-factor authentication when available.', 1, 2),
(8, 2, 'A classmate shares a private photo in a group chat. What is the most responsible action?', 'Respect privacy and do not forward private content without permission.', 1, 3),
(9, 2, 'Before sharing a surprising news post, you should:', 'Check the original source and compare with reliable sources before sharing.', 1, 4),
(10, 2, 'What is phishing?', 'Phishing is a deceptive attempt to obtain sensitive information or cause an unsafe action.', 1, 5),
(11, 3, 'Which file extension is commonly used for a Microsoft Excel workbook?', 'The .xlsx extension is commonly used for modern Excel workbooks.', 1, 1),
(12, 3, 'Which application type is best suited to organizing numerical data and calculating totals?', 'Spreadsheet applications support tabular data, formulas, and calculations.', 1, 2),
(13, 3, 'Which filename is the clearest choice for the second version of a research outline?', 'A descriptive name with a version number is easier to identify and organize.', 1, 3),
(14, 3, 'What is a good way to protect important school files?', 'Maintain a backup in a separate safe location and check that it is current.', 1, 4),
(15, 3, 'Which format is commonly used to share a document while preserving its layout across devices?', 'PDF is commonly used to distribute documents with consistent layout.', 1, 5);

INSERT INTO question_options (question_id, option_label, option_text, is_correct)
VALUES
(1, 'A', 'Monitor', 0), (1, 'B', 'Central Processing Unit (CPU)', 1), (1, 'C', 'Keyboard', 0), (1, 'D', 'Printer', 0),
(2, 'A', 'RAM', 1), (2, 'B', 'USB flash drive', 0), (2, 'C', 'SSD', 0), (2, 'D', 'DVD', 0),
(3, 'A', 'Monitor', 0), (3, 'B', 'Speaker', 0), (3, 'C', 'Keyboard', 1), (3, 'D', 'Projector', 0),
(4, 'A', 'It is used only to browse websites', 0), (4, 'B', 'It manages hardware and supports applications', 1), (4, 'C', 'It is a physical storage device', 0), (4, 'D', 'It replaces all application software', 0),
(5, 'A', 'RAM', 0), (5, 'B', 'CPU cache only', 0), (5, 'C', 'SSD or hard drive', 1), (5, 'D', 'A running application window', 0),
(6, 'A', 'Click immediately because the message sounds urgent', 0), (6, 'B', 'Reply with your password to confirm your identity', 0), (6, 'C', 'Avoid the link and verify the request through an official channel', 1), (6, 'D', 'Forward the message to every classmate', 0),
(7, 'A', 'Use the same short password everywhere', 0), (7, 'B', 'Use unique, long passwords and enable MFA', 1), (7, 'C', 'Share your password with trusted classmates', 0), (7, 'D', 'Write your password in a public group chat', 0),
(8, 'A', 'Forward it to other groups', 0), (8, 'B', 'Post it publicly', 0), (8, 'C', 'Respect the person''s privacy and do not share it', 1), (8, 'D', 'Edit it into a joke without permission', 0),
(9, 'A', 'Share it immediately', 0), (9, 'B', 'Check the source and compare reliable reports', 1), (9, 'C', 'Trust it if it has many reactions', 0), (9, 'D', 'Change the headline and repost it', 0),
(10, 'A', 'A method for backing up files', 0), (10, 'B', 'A computer hardware upgrade', 0), (10, 'C', 'A deceptive attempt to steal information or prompt unsafe actions', 1), (10, 'D', 'A type of spreadsheet formula', 0),
(11, 'A', '.mp3', 0), (11, 'B', '.xlsx', 1), (11, 'C', '.jpg', 0), (11, 'D', '.pptx', 0),
(12, 'A', 'Spreadsheet application', 1), (12, 'B', 'Image editor', 0), (12, 'C', 'Audio player', 0), (12, 'D', 'Video player', 0),
(13, 'A', 'finalfinalnew.docx', 0), (13, 'B', 'document1.docx', 0), (13, 'C', 'Research_Outline_v2.docx', 1), (13, 'D', 'untitled.docx', 0),
(14, 'A', 'Keep only one copy on the same device', 0), (14, 'B', 'Delete the original after saving once', 0), (14, 'C', 'Maintain a backup in a separate safe location', 1), (14, 'D', 'Share your account password with classmates', 0),
(15, 'A', '.exe', 0), (15, 'B', '.pdf', 1), (15, 'C', '.tmp', 0), (15, 'D', '.bat', 0);

-- Sample historical attempts for dashboard and progress testing.
-- These are demo records, not real student results.
INSERT INTO quiz_attempts
(attempt_id, user_id, quiz_id, attempt_number, started_at, submitted_at, score, total_points, percentage, result_status)
VALUES
(1, 2, 1, 1, '2026-10-12 08:10:00', '2026-10-12 08:16:00', 4, 5, 80.00, 'PASSED'),
(2, 2, 2, 1, '2026-10-13 09:20:00', '2026-10-13 09:27:00', 3, 5, 60.00, 'FAILED'),
(3, 2, 2, 2, '2026-10-15 14:00:00', '2026-10-15 14:06:00', 4, 5, 80.00, 'PASSED'),
(4, 3, 1, 1, '2026-10-12 10:00:00', '2026-10-12 10:05:00', 3, 5, 60.00, 'FAILED'),
(5, 3, 1, 2, '2026-10-14 10:15:00', '2026-10-14 10:20:00', 4, 5, 80.00, 'PASSED'),
(6, 4, 3, 1, '2026-10-14 13:30:00', '2026-10-14 13:36:00', 5, 5, 100.00, 'PASSED'),
(7, 5, 2, 1, '2026-10-15 08:30:00', '2026-10-15 08:37:00', 2, 5, 40.00, 'FAILED'),
(8, 6, 3, 1, '2026-10-16 15:10:00', '2026-10-16 15:16:00', 4, 5, 80.00, 'PASSED');

INSERT INTO quiz_answers
(attempt_id, question_id, selected_option_id, is_correct, points_awarded, answered_at)
VALUES
-- Maria: Computer Fundamentals, 4/5
(1, 1, 2, 1, 1, '2026-10-12 08:11:00'),
(1, 2, 5, 1, 1, '2026-10-12 08:12:00'),
(1, 3, 11, 1, 1, '2026-10-12 08:13:00'),
(1, 4, 14, 1, 1, '2026-10-12 08:14:00'),
(1, 5, 17, 0, 0, '2026-10-12 08:15:00'),
-- Maria: Internet Safety first attempt, 3/5
(2, 6, 22, 1, 1, '2026-10-13 09:21:00'),
(2, 7, 25, 1, 1, '2026-10-13 09:22:00'),
(2, 8, 30, 0, 0, '2026-10-13 09:24:00'),
(2, 9, 34, 1, 1, '2026-10-13 09:25:00'),
(2, 10, 38, 0, 0, '2026-10-13 09:26:00'),
-- Maria: Internet Safety second attempt, 4/5
(3, 6, 22, 1, 1, '2026-10-15 14:01:00'),
(3, 7, 25, 1, 1, '2026-10-15 14:02:00'),
(3, 8, 31, 1, 1, '2026-10-15 14:03:00'),
(3, 9, 34, 1, 1, '2026-10-15 14:04:00'),
(3, 10, 38, 0, 0, '2026-10-15 14:05:00'),
-- Juan: Computer Fundamentals first attempt, 3/5
(4, 1, 1, 0, 0, '2026-10-12 10:01:00'),
(4, 2, 5, 1, 1, '2026-10-12 10:02:00'),
(4, 3, 11, 1, 1, '2026-10-12 10:03:00'),
(4, 4, 14, 1, 1, '2026-10-12 10:04:00'),
(4, 5, 16, 0, 0, '2026-10-12 10:05:00'),
-- Juan: second attempt, 4/5
(5, 1, 2, 1, 1, '2026-10-14 10:16:00'),
(5, 2, 5, 1, 1, '2026-10-14 10:17:00'),
(5, 3, 11, 1, 1, '2026-10-14 10:18:00'),
(5, 4, 14, 1, 1, '2026-10-14 10:19:00'),
(5, 5, 16, 0, 0, '2026-10-14 10:20:00'),
-- Angelo: Productivity Tools, 5/5
(6, 11, 42, 1, 1, '2026-10-14 13:31:00'),
(6, 12, 45, 1, 1, '2026-10-14 13:32:00'),
(6, 13, 51, 1, 1, '2026-10-14 13:33:00'),
(6, 14, 55, 1, 1, '2026-10-14 13:34:00'),
(6, 15, 58, 1, 1, '2026-10-14 13:35:00'),
-- Katrina: Internet Safety, 2/5
(7, 6, 19, 0, 0, '2026-10-15 08:31:00'),
(7, 7, 25, 1, 1, '2026-10-15 08:32:00'),
(7, 8, 29, 0, 0, '2026-10-15 08:34:00'),
(7, 9, 34, 1, 1, '2026-10-15 08:35:00'),
(7, 10, 36, 0, 0, '2026-10-15 08:36:00'),
-- Patrick: Productivity Tools, 4/5
(8, 11, 42, 1, 1, '2026-10-16 15:11:00'),
(8, 12, 45, 1, 1, '2026-10-16 15:12:00'),
(8, 13, 49, 0, 0, '2026-10-16 15:13:00'),
(8, 14, 55, 1, 1, '2026-10-16 15:14:00'),
(8, 15, 58, 1, 1, '2026-10-16 15:15:00');

-- Helpful starter queries:
-- 1. List student accounts:
-- SELECT u.user_id, u.username, CONCAT(u.first_name, ' ', u.last_name) AS student_name,
--        sp.student_number, sp.section
-- FROM users u JOIN student_profiles sp ON sp.user_id = u.user_id
-- WHERE u.role = 'STUDENT';

-- 2. Student quiz history:
-- SELECT q.quiz_title, qa.attempt_number, qa.score, qa.total_points, qa.percentage,
--        qa.result_status, qa.submitted_at
-- FROM quiz_attempts qa JOIN quizzes q ON q.quiz_id = qa.quiz_id
-- WHERE qa.user_id = 2 ORDER BY qa.started_at DESC;

-- 3. Quiz questions and answer options:
-- SELECT q.question_text, qo.option_label, qo.option_text, qo.is_correct
-- FROM questions q JOIN question_options qo ON qo.question_id = q.question_id
-- WHERE q.quiz_id = 1 ORDER BY q.sort_order, qo.option_label;
