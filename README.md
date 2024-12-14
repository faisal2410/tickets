Simple Ticket System with PHP PDO
===================================


Installation
------------
- Create a database
- Execute the following table creation script in the database
- Set connection params in config.php
- Run the index.php file
- You may use the following command (from app root directory) to start php server
```bash
php -S localhost:8000
# Then open http://localhost:8000 in your browser
```


Table creation script
------------------------
```sql
CREATE TABLE tickets (
     id INT AUTO_INCREMENT PRIMARY KEY,
     title VARCHAR(255) NOT NULL,
     description TEXT NOT NULL,
     priority ENUM('Low', 'Medium', 'High') NOT NULL,
     status ENUM('Open', 'In Progress', 'Resolved') NOT NULL DEFAULT 'Open',
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Tasks
-----------
- [ ] Add a search functionality to the ticket list page
- [ ] Add a filter functionality with priority and status the ticket list page
- [ ] Add a pagination functionality to the ticket list page
- [ ] Add a ticket deletion functionality with confirmation modal