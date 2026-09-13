🌱 AgroVenture – Smart Agricultural Service Platform
📌 Project Overview
AgroVenture is a web-based agricultural service platform that enables Admins, Landowners, Farmers, and Green AgroVenture Owners to collaborate efficiently.
The system allows digital management of agricultural activities, equipment rental, seasonal jobs, irrigation, land cultivation, and harvesting services.

👥 Types of Users
1.	Admin
2.	Landowner
3.	Farmer
4.	Green AgroVenture Owner

🔐 Common Features (Available to All Users)
🔑 Authentication
•	User Registration
•	Login to the system
•	Logout from the system
👤 Account Management
•	View profile information
•	Edit profile information
•	Delete account
•	Change or reset password
📊 Dashboard
•	Personalized dashboard after successful login
•	Role-based access control

🛠️ Features by User Type

👑 Admin Features
•	Control and manage all users
•	Verify all registered users
•	Activate/deactivate user accounts
•	Track and handle all services during critical situations
•	Verify all services provided by the system

🏡 Landowner Features
•	Hire farmers for seasonal or permanent work
•	Get agricultural services from Green AgroVenture
•	Browse, cart, purchase and rent equipment
•	Provide ratings and feedback for each service

🌾 Farmer Features
•	Get new seasonal job opportunities from landowners
•	Manage profile and availability status
•	Rent agricultural equipment from Green AgroVenture
•	Assist and collaborate with Green AgroVenture services

🚜 Green AgroVenture (Company) Owner Features
•	Agricultural equipment CRUD (add/edit/delete instruments)
•	Manage purchase and rental orders
•	Irrigation project management
•	Land cultivation services
•	Harvester services

🧩 Technology Stack
•	Frontend: HTML, CSS, JavaScript
•	Backend: PHP
•	Database: MySQL
•	Server: Apache (XAMPP)

🎯 Project Objectives
•	Digitalize agricultural services
•	Create job opportunities for farmers
•	Simplify communication between landowners and service providers
•	Ensure secure and role-based system access

🔀 About This Merged Version
This project is the original AgriLand-Ecosystem codebase, kept as the base, with compatible features from the Rural Village Empowerment System merged in where they fit the existing architecture:
•	Role-based Admin, Landowner, Farmer and Company support
•	Admin user management with activate/deactivate support
•	Farmer profile, availability and hire-request workflow
•	Equipment/instrument CRUD for companies
•	Landowner equipment cart, purchase and rental workflow
•	Company purchase/rental order management
•	Profile management and password reset
•	Clean `agri_db` schema with no demo/sample records

Existing AgriLand table names and routing were preserved to avoid breaking the existing project.

🚀 Future Enhancements
•	Online payment integration
•	Real-time service tracking
•	Mobile application support
•	Advanced analytics for admin

📄 License
This project is developed for academic purposes as part of the Web Technology course.

## Run Locally (XAMPP)

1. Copy/move the project to:
	 - `xampp/htdocs/AgriLandEcosystem`
2. Start `Apache` and `MySQL` from XAMPP Control Panel.
3. Open this URL in browser:
	 - `http://localhost/AgriLandEcosystem/`

## Database Setup

This app uses the following DB config in `app/core/Database.php`:

- host: `localhost`
- database: `agri_db`
- user: `root`
- password: `` (empty)

Create/import `agri_db` from `sql/agri_db.sql` in phpMyAdmin. The clean SQL contains schema only (no demo/sample records).

## Common Issues

- `404 Not Found`
	- Check project path is exactly inside `htdocs/Projects/AgriLand_Ecosystem`.
	- Use `http://localhost/Projects/AgriLand_Ecosystem/` (not a file path).

- `Connection error: SQLSTATE...`
	- MySQL is not running, DB name is wrong, or schema is not imported.

- `SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it`
	- MySQL is not listening on the configured port.
	- Open XAMPP Control Panel and start `MySQL`.
	- If your MySQL runs on a different port (example `3307`), set env vars before Apache startup:
		- `DB_HOST` (default: `localhost`)
		- `DB_PORT` (default: `3306`)
		- `DB_NAME` (default: `agri_db`)
		- `DB_USER` (default: `root`)
		- `DB_PASS` (default: empty)

- `php is not recognized` in terminal
	- This only affects CLI commands.
	- Browser app via XAMPP Apache can still run.
	- Optional: add `C:\xampp\php` to system `PATH` for terminal PHP commands.
