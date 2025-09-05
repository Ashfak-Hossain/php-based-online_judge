CREATE TABLE problems (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  slug VARCHAR(50) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  statement MEDIUMTEXT NOT NULL,
  input_format TEXT NOT NULL,
  output_format TEXT NOT NULL,
  constraints TEXT NOT NULL,
  example_input TEXT NOT NULL,
  example_output TEXT NOT NULL,
  difficulty ENUM('easy', 'medium', 'hard') NOT NULL DEFAULT 'easy',
  time_limit INT NOT NULL DEFAULT 2000, -- ms
  memory_limit INT NOT NULL DEFAULT 256, -- mb
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_by BIGINT UNSIGNED,
  INDEX(created_by),
  INDEX (slug),
  INDEX (difficulty),
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;


CREATE TABLE test_cases (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    problem_id BIGINT UNSIGNED NOT NULL,
    input_file VARCHAR(255) NOT NULL,
    output_file VARCHAR(255) NOT NULL,
    points INT NOT NULL DEFAULT 1,
    visible TINYINT(1) DEFAULT 0,  -- 1 - sample, 0 - hidden
    FOREIGN KEY (problem_id) REFERENCES problems(id) ON DELETE CASCADE,
    INDEX(problem_id)
) ENGINE=InnoDB;

CREATE TABLE submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    problem_id BIGINT UNSIGNED NOT NULL,
    language ENUM('cpp17','cpp20','py3','java') NOT NULL DEFAULT 'cpp17',
    code MEDIUMTEXT NOT NULL,
    verdict ENUM('PENDING','RUNNING','AC','WA','TLE','RE','CE') DEFAULT 'PENDING',
    exec_time INT DEFAULT NULL,
    memory_kb INT DEFAULT NULL,
    compiled_ok TINYINT(1) DEFAULT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (problem_id) REFERENCES problems(id) ON DELETE CASCADE,
    INDEX(user_id),
    INDEX(problem_id),
    INDEX(verdict)
) ENGINE=InnoDB;


CREATE TABLE submission_runs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    submission_id BIGINT UNSIGNED NOT NULL,
    test_case_id BIGINT UNSIGNED NOT NULL,
    status ENUM('AC','WA','TLE','RE','SKIP') NOT NULL,
    time_ms INT DEFAULT NULL,
    memory_kb INT DEFAULT NULL,
    stderr TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE,
    FOREIGN KEY (test_case_id) REFERENCES test_cases(id) ON DELETE CASCADE,
    INDEX(submission_id),
    INDEX(test_case_id)
) ENGINE=InnoDB;