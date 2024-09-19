---

# Leave Management Platform

## Project Description

The "Leave Management Platform" project aims to streamline the process of managing employee leaves at IT Development Canada. The platform allows employees to log in, access their personal space, check their leave balances, submit leave requests, and track the status of their requests. Administrators, who are responsible for HR management, have additional functionalities such as managing employees, reviewing leave requests, approving or rejecting requests, and monitoring leave balances for all employees.

The leave approval process involves two stages; first by the immediate supervisor (Manager) and then by the company director (Admin). Any leave rejection requires a specific comment detailing the reason for rejection.

## Key Features

- **User Roles:**
  - **Administrator:**
    - Manage employees
    - View and manage leave requests of all employees
    - Approve or reject leave requests
    - View leave balances of all employees

  - **Manager:**
    - Log in to their personal space
    - Manage their own leave requests
    - View their leave balance
    - Receive leave requests from their department
    - Approve or reject leave requests from their department

  - **Regular User:**
    - Log in to their personal space
    - Manage their own leave requests
    - View their leave balance

## Technologies Used

- Symfony 7 - PHP framework for backend development
- PostgreSQL - Database management system
- HTML, CSS, JavaScript, (Twig) - Frontend web technologies
- Git - Version control system
- GitHub - Repository hosting and collaboration platform

## Installation and Setup

### Prerequisites

- PHP >= 7.4
- Composer
- PostgreSQL

### Installation Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/Ahmed-Ayari/Leave_Manager.git
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Configure environment variables:
   - Copy `.env.example` to `.env` and configure your database connection and other necessary variables.

5. Set up the database:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

6. Build frontend assets:
   ```bash
   npm run build
   ```

7. Start the Symfony server:
   ```bash
   symfony server:start
   ```

8. Access the application in your web browser:
   ```
   http://localhost:8000
   ```

## Contributing

Contributions are welcome! Feel free to fork the repository and submit pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---
