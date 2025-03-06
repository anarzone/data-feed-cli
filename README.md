# Data Feed CLI

A Symfony-based command-line tool for importing CSV data into a database. This project is designed to be easily extended to support multiple storage solutions (MySQL via Doctrine ORM and MongoDB via Doctrine MongoDB ODM).

## Requirements

- PHP 8.3
- Composer
- Symfony CLI (optional, but recommended)
- MySQL or MongoDB (depending on your chosen configuration)
- PHPUnit (for running tests)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://your-repo-url.git
   cd your-repo-directory
   
    ```

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Configure Environment Variables::**

   ```bash

    ### App Settings ###
    DATABASE_TYPE="mysql"   # Options: "mysql" or "mongodb"
    CSV_FILE_PATH="%kernel.project_dir%/feed.csv"
    
    ### MySQL Connection (Doctrine ORM) ###
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0"
    
    ### MongoDB Connection (Doctrine ODM) ###
    MONGODB_URL="mongodb://db_user:db_password@127.0.0.1:27017/db_name"
    ```
   
