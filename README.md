# 🎬 Streamflix

A modern Netflix-inspired streaming platform built with PHP, MySQL, and Bootstrap 5. Streamflix provides a complete movie streaming experience with user management, admin panel, and responsive design.

## 🌟 Features

### User Features
- **User Authentication**: Secure registration and login system
- **Movie Browsing**: Browse movies by categories with beautiful card layouts
- **Search Functionality**: Find movies by title or genre
- **Movie Details**: Detailed movie pages with ratings and descriptions
- **Personal Watchlist**: Save favorite movies to "My List"
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Dark/Light Theme**: Toggle between themes for optimal viewing experience

### Admin Features
- **Admin Dashboard**: Comprehensive statistics and overview
- **Movie Management**: Add, edit, and delete movies
- **User Management**: Manage user accounts and permissions
- **Category Management**: Organize movies into categories
- **Image Management**: Automated image handling and optimization

## 🛠️ Technology Stack

- **Backend**: PHP 8.x with PDO for database operations
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Framework**: Bootstrap 5.3 for responsive UI
- **Icons**: Bootstrap Icons
- **Security**: Password hashing, SQL injection prevention, session management

## 📋 Requirements

- **Web Server**: Apache/Nginx with PHP support
- **PHP**: Version 8.0 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Extensions**: PDO, PDO_MySQL

### Recommended Development Environment
- **Laragon** (Windows) or **XAMPP** (Cross-platform)
- **PHP 8.1+**
- **MySQL 8.0+**

## 🚀 Installation

### 1. Clone or Download the Project
```bash
git clone https://github.com/KevinvdWeert/streamflix-project.git
# or download and extract the ZIP file
```

### 2. Setup Web Server
Place the project folder in your web server's document root:
- **Laragon**: `C:\laragon\www\`
- **XAMPP**: `C:\xampp\htdocs\`
- **WAMP**: `C:\wamp64\www\`

### 3. Database Setup
1. Create a new MySQL database named `streamflix`
2. Import the database schema:
   ```sql
   mysql -u root -p streamflix < database/streamflix.sql
   ```
   Or use phpMyAdmin to import `database/streamflix.sql`

### 4. Configuration
Update database credentials in `includes/db-connection.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'streamflix');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 5. Access the Application
Navigate to `http://localhost/streamflix-project` in your web browser.

## 👥 Default Accounts

### Admin Account
- **Username**: `admin`
- **Password**: `admin123`
- **Email**: `admin@streamflix.nl`

### Test User Account
- **Username**: `testuser`
- **Password**: `password`
- **Email**: `test@streamflix.nl`

## 📁 Project Structure

```
streamflix-project/
├── 📄 index.php                 # Landing page
├── 📄 home.php                  # Main dashboard after login
├── 📄 update-movie-images.php   # Image management utility
│
├── 📁 api/                      # API endpoints
│   └── fetch_ratings.php
│
├── 📁 assets/                   # Static assets
│   ├── css/
│   │   └── style.css           # Main stylesheet
│   ├── img/                    # Images and logos
│   ├── js/
│   │   └── script.js          # JavaScript functionality
│   └── videos/                 # Video files
│
├── 📁 database/                 # Database files
│   ├── streamflix.sql          # Database schema
│   └── streamflix ERD.mwb      # Entity Relationship Diagram
│
├── 📁 includes/                 # Shared PHP components
│   ├── db-connection.php       # Database connection
│   ├── header.php              # Common header
│   ├── footer.php              # Common footer
│   ├── navbar.php              # Navigation component
│   ├── image-helper.php        # Image processing utilities
│   └── security-helper.php     # Security functions
│
├── 📁 pages/                    # Application pages
│   ├── login.php               # User login
│   ├── register.php            # User registration
│   ├── movies.php              # Movie catalog
│   ├── detail.php              # Movie details
│   ├── search.php              # Search functionality
│   ├── mylist.php              # User's watchlist
│   ├── account.php             # User account management
│   ├── admin.php               # Admin dashboard
│   ├── admin_movies.php        # Movie management
│   ├── admin_users.php         # User management
│   ├── admin_statistics.php    # Admin statistics
│   ├── contact.php             # Contact page
│   ├── faq.php                 # FAQ page
│   └── helpdesk.php            # Help desk
│
└── 📁 logs/                     # Application logs
```

## 🔧 Configuration & Customization

### Database Configuration
The application automatically creates required database tables if they don't exist. You can customize the database structure by modifying `database/streamflix.sql`.

### Styling & Theming
- Main styles are in `assets/css/style.css`
- The application supports both dark and light themes
- Bootstrap 5 classes are used throughout for responsive design

### Security Features
- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- Session-based authentication
- CSRF protection helpers
- Input sanitization functions

## 🎯 Usage

### For Users
1. **Registration**: Create an account on the registration page
2. **Browse Movies**: Explore the movie catalog by categories
3. **Search**: Use the search function to find specific movies
4. **Watchlist**: Add movies to your personal list
5. **Account**: Manage your profile and preferences

### For Administrators
1. **Login**: Use admin credentials to access admin features
2. **Dashboard**: View site statistics and overview
3. **Movie Management**: Add, edit, or remove movies
4. **User Management**: Manage user accounts and permissions
5. **Categories**: Organize movies into different genres

## 🐛 Troubleshooting

### Common Issues

**Database Connection Error**
- Verify MySQL service is running
- Check database credentials in `includes/db-connection.php`
- Ensure the `streamflix` database exists

**Images Not Loading**
- Check file permissions for `assets/img/` directory
- Verify image paths in the database
- Run `update-movie-images.php` to fix image references

**Session Issues**
- Ensure PHP sessions are enabled
- Check session configuration in `php.ini`
- Clear browser cookies and cache

**Admin Access**
- Verify admin account exists in database
- Check user role is set to 'admin'
- Use default admin credentials: `admin` / `admin123`

## 🔒 Security Considerations

- Change default admin credentials after installation
- Use strong passwords for all accounts
- Keep PHP and MySQL updated
- Configure proper file permissions
- Use HTTPS in production environments
- Regular security updates and patches

## 🚧 Development Roadmap

- [ ] Video streaming integration
- [ ] Advanced search filters
- [ ] User reviews and ratings system
- [ ] Social features (sharing, recommendations)
- [ ] Mobile app development
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Payment integration for premium features

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Kevin van de Weert**
- GitHub: [@KevinvdWeert](https://github.com/KevinvdWeert)

## 🙏 Acknowledgments

- Bootstrap team for the excellent CSS framework
- Bootstrap Icons for the comprehensive icon set
- Netflix for design inspiration
- The PHP community for excellent documentation and resources

---

**Made with ❤️ for movie lovers everywhere!**