# Project2 - Student API

A comprehensive Laravel 12 RESTful API with Docker containerization, featuring Sanctum authentication and complete documentation.

## 🚀 Features

- **RESTful API** - Complete CRUD operations for student management
- **Authentication** - Sanctum token-based authentication with username login
- **Docker Ready** - Fully containerized with automated setup
- **Role-Based Access** - Admin and user permissions
- **Advanced Filtering** - Search by name, course, major, and year
- **Documentation** - Complete Hugo-based documentation site

## 📁 Project Structure

```
project2/
├── code/
│   ├── Student_API/        # Laravel application
│   ├── setup.sh           # Automated Docker setup script
│   └── command.sh         # API testing script
├── presentation/
│   └── docs/              # Hugo documentation site
├── plan/                  # Project planning documents
├── project2_outline.md    # Project outline
└── project2_rubric.md     # Project rubric
```

## 🏃 Quick Start

### Using Docker (Recommended)

```bash
cd code
./setup.sh
# Select option 1 for initial setup
```

Access points:
- Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081
- Documentation: https://HJ5-U.github.io/

### Default Credentials

**Admin:**
- Username: `Admin`
- Password: `password`

**Regular User:**
- Username: `user`
- Password: `password`

## 📚 Documentation

Complete documentation is available at: https://HJ5-U.github.io/

Topics covered:
- Getting Started Guide
- API Reference with all endpoints
- Deployment Guide
- Docker Configuration

## 🛠️ Technology Stack

- **Backend:** Laravel 12, PHP 8.3
- **Database:** MySQL 8.0
- **Authentication:** Laravel Sanctum
- **Containerization:** Docker, Docker Compose
- **Documentation:** Hugo Static Site Generator
- **Frontend:** Blade Templates, Tailwind CSS

## 📝 API Endpoints

### Authentication
- `POST /api/v1/register` - Register new user
- `POST /api/v1/login` - Login and get token
- `POST /api/v1/logout` - Logout and revoke token

### Students
- `GET /api/v1/students` - List all students
- `GET /api/v1/students/{id}` - Get single student
- `POST /api/v1/students` - Create student
- `PUT /api/v1/students/{id}` - Update student
- `DELETE /api/v1/students/{id}` - Delete student

### Filtering
- `GET /api/v1/students/by-name/{name}`
- `GET /api/v1/students/by-course/{course}`
- `GET /api/v1/students/by-major/{major}`
- `GET /api/v1/students/by-year/{year}`

## 🧪 Testing

Run the automated test script:
```bash
cd code
./command.sh
```

## 🐳 Docker Commands

```bash
# Start containers
./setup.sh  # Select option 2

# Stop containers
./setup.sh  # Select option 3

# View logs
./setup.sh  # Select option 5

# Access shell
./setup.sh  # Select option 8
```

## 📦 What's Included

- ✅ Complete Laravel API with authentication
- ✅ Docker setup with 3 containers (app, MySQL, phpMyAdmin)
- ✅ Automated setup script with 10 management options
- ✅ API testing script
- ✅ Hugo documentation website
- ✅ Sample data seeder
- ✅ Database migrations

## 🔐 Security Features

- Token-based authentication
- Role-based access control
- Password hashing
- CORS configuration
- Input validation
- SQL injection protection

## 📸 Screenshots

See the documentation site for screenshots of:
- Login interface
- Dashboard
- API responses
- Docker setup
- Database management

## 🤝 Contributing

This is a student project for educational purposes.

## 📄 License

Educational project - no specific license.

## 🔗 Links

- **Documentation:** https://HJ5-U.github.io/
- **Repository:** https://github.com/HJ5-U/
- **Live Demo:** http://localhost:8080 (when running locally)

## 👤 Author

HJ5-U

---

*Built with Laravel 12, Docker, and Hugo*
