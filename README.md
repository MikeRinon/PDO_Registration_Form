# Dream Profession Registration (PDO + MySQL)

---

# Overview
- Simple CRUD registration system using PHP's PDO extension and MySQL.
- Stores applicants interested in their "dream profession" and related info.

---

# Files
- `db.php` - PDO connection (update credentials if needed).
- `index.php` - List and search records.
- `create.php` - Add new applicant.
- `edit-update.php` - Edit / Update an applicant (renamed from `edit.php`).
- `delete.php` - Confirm and delete an applicant.
- `styles.css` - Basic styles.
- `schema.sql` - SQL to create database and `applicants` table.

---

Setup (XAMPP)
1. Copy the `PDO_Registration` folder into `c:/xampp/htdocs/`.
2. Start Apache and MySQL via the XAMPP Control Panel.
3. Create the database and table:
   - Using phpMyAdmin: import `schema.sql` or run its SQL.
4. If you use a different DB user/password, edit `db.php` and set `$user` and `$pass` accordingly.
5. Open in your browser: `http://localhost/PDO_Registration/index.php`
