-- MySQL schema for MKM Travel Invoice System
CREATE TABLE `users` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `customers` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(200) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text,
  `identity_no` varchar(100) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `invoices` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `invoice_no` varchar(100) NOT NULL,
  `customer_id` int NOT NULL,
  `date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `items` text NOT NULL, -- store JSON array of items [{desc,qty,price}]
  `sub_total` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) DEFAULT 0,
  `total` decimal(12,2) NOT NULL,
  `status` enum('Unpaid','Paid','Partially Paid') DEFAULT 'Unpaid',
  `notes` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `payments` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `invoice_id` int NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` varchar(100) DEFAULT NULL,
  `note` text,
  `paid_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password is plain text 'admin123' for simplicity; change after install)
INSERT INTO users (username, password) VALUES ('admin', 'admin123');
