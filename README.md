---

# MyFoodRecipe

A web-based application developed using PHP and CSS that allows users to explore, add, and manage food recipes.

## Features

- **User Registration and Login**: Users can create accounts and log in to access personalized features.
- **Recipe Management**: Add new recipes, view existing ones, and manage your personal recipe collection.
- **Admin Dashboard**: Administrative interface for managing users and overseeing recipe submissions.
- **Comment System**: Users can comment on recipes, fostering community interaction.
- **Top Contributors**: Highlighting users who contribute the most recipes.

## File Structure

- `index.php`: Homepage of the application.
- `register.php` & `login.php`: User authentication pages.
- `addrecipe.php`: Form for adding new recipes.
- `recipe.php`: Displays individual recipes.
- `admin_dashboard.php`: Admin interface for managing the application.
- `connect.php` & `connect_db.php`: Database connection scripts.
- `style.css`: Styling for the application.

## Getting Started

### Prerequisites

- A web server with PHP support (e.g., XAMPP, WAMP)
- MySQL or compatible database system

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/rahulshah1122/myfoodrecipe.git
   ```


2. Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).

3. Import the database:
   - Create a new MySQL database.
   - Import the provided SQL file (if available) to set up the necessary tables.

4. Update database connection settings in `connect.php` and `connect_db.php` with your database credentials.

5. Start the web server and navigate to `http://localhost/myfoodrecipe` in your browser.

## Usage

- Register a new account or log in with existing credentials.
- Browse available recipes or add your own.
- Interact with other users through comments.
- Admins can manage user submissions and oversee site activity via the admin dashboard.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any enhancements or bug fixes.

## License

This project is open-source and available under the [MIT License](LICENSE).

---

*Note: This project is a basic implementation and may not cover all aspects of a full-fledged recipe management system.*

--- 
