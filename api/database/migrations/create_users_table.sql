-- api/database/migrations/create_users_table.sql

CREATE TABLE users (
    id INT IDENTITY(1,1) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Insert test data
INSERT INTO users (name, email) VALUES ('John Doe', 'john@example.com'); 