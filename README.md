# Home Glazer CRM by Codelli Technologies

![Home Glazer CRM](https://www.homeglazer.com/wp-content/uploads/2021/05/rsz_home_glazerpng.png.webp)

Welcome to the Home Glazer CRM, a complete end-to-end solution tailored for Home Glazer, a painting company. Developed by Codelli Technologies using Laravel 10, this private white-label CRM is meticulously designed to meet Home Glazer's industry-specific requirements, simplifying and optimizing various aspects of their business operations.

## Requirements

This CRM is developed on laravel 10. You will need php8+ to run this smoothly. Apache or Nginx is used in development to test.

## Features

- **User Management with RBAC:** Effectively manage user roles and permissions, ensuring controlled access and data security.
- **Lead Management:** Seamlessly track and manage leads, from initial contact to successful conversion.
- **Invoice Management:** Streamline billing processes by creating, sending, and tracking invoices effortlessly.
- **Inventory Management:** Keep meticulous records of painting supplies and materials, ensuring efficient stock management.
- **Employee Management:** Manage employee information, roles, and responsibilities within the company structure.
- **Attendance Management:** Monitor and manage employee attendance to foster a productive work environment.
- **Payroll Management:** Accurately calculate and manage employee salaries and compensation.
- **Expense Management:** Track and categorize expenses to gain insights into company spending patterns.
- **Project Management:** Plan, execute, and monitor painting projects comprehensively from initiation to completion.
- **Accounts Management:** Maintain detailed records of financial transactions and statements.
- **Insightful Dashboards:** Gain valuable insights into various business aspects through visually appealing and informative dashboards customized for each module.

## Installation

To set up the Home Glazer CRM locally, follow these steps:

1. Clone the private repository from GitHub.
2. Navigate to the project directory:

   ```bash
   cd hgcrm
   ```

3. Install the required dependencies using Composer:

   ```bash
   composer install
   ```

4. Configure your `.env` file with the necessary environment variables, including database settings.

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Run the database migrations:

   ```bash
   php artisan migrate
   ```

7. Start the development server:

   ```bash
   php artisan serve
   ```

8. Access the CRM through your web browser at `http://localhost:8000`.

## Contact

For any inquiries or assistance, please contact us at codellitech@gmail.com. We're excited to provide Home Glazer with an efficient and tailored CRM solution that aligns with their painting business needs.

## Development and Maintenance

This CRM is developed and maintained by Codelli Technologies.

## License

This project is licensed under the [MIT License](LICENSE).