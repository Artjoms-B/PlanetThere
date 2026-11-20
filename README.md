# PlanetThere

PlanetThere is a dynamic platform designed to connect event creators and attendees. It facilitates seamless event management, registration, and interaction for users in an intuitive and visually appealing environment. The project was completed for the Web Development Module at Transport and Telecommunication Institute.

---

## Project Overview
PlanetThere is a platform built using HTML, CSS, JavaScript, PHP and a MySQL database. It follows the Model-View-Controller (MVC) architecture. It offers event attendees and creators tools to interact, manage, and participate in events effortlessly. With user-friendly features like registration, waitlisting, and event moderation, PlanetThere ensures a seamless experience for all users.

---

## Features

### For Attendees
- Create and manage accounts, including profile customization.
- Search for events using keywords or advanced filtering.
- Register for events or join a waitlist when full.
- Review and comment on attended events
- Follow other users and view their activity.
- Block or unblock users.
- View attended event history.

### For Event Creators
- Create, update, and delete events.
- Easily plan frequent events with templates.
- Remove participants from events.

### For Admins
- Moderate user-generated content and ban/unban users.
- Approve, deny, or remove events violating policies.
- Customize and manage the FAQ page.

---

## Technology Stack
- **Languages**: HTML, CSS, JavaScript, PHP
- **Architecture**: Model-View-Controller (MVC)
- **Database**: Uses PHP for backend data handling
- **API**: Uses Nominatim API for a geocoding service
- **No Frameworks**: The project is built from the ground up using native technologies.

---

## Project Structure

```plaintext
+---.vscode
+---app
|   +---controllers
|   +---core
|   +---models
|   +---PhpMailer
    +---services
|   \---views
|       +---about
|       +---admin
|       +---event
|       +---FAQ
|       +---home
|       +---partials
|       +---TAC
|       \---user
+---config
+---public
|   +---assets
|   |   +---css
|   |   +---fonts
|   |   |   \---fontawesome-free-6.7.2-web
|   |   |       +---css
|   |   |       +---js
|   |   |       +---less
|   |   |       +---metadata
|   |   |       +---scss
|   |   |       +---sprites
|   |   |       +---svgs
|   |   |       |   +---brands
|   |   |       |   +---regular
|   |   |       |   \---solid
|   |   |       \---webfonts
|   |   \---images
|   |       +---dashboardimages
|   |       \---sidebarpics
|   \---uploads
|       +---events
|       \---users
+---routes
+---views
    \---layout
```


---

## Installation

1. Clone the repository:
   ```bash
   git clone 
   ```
2. Navigate to the project directory:
   ```bash
   cd planetthere
   ```
3. Set up your server environment:
   - Install a local server like XAMPP or WAMP.
   - Place the project in the `htdocs` folder.
4. Import the database:
   - Locate the `planetthere_new.sql` file in the project.
   - Use phpMyAdmin to import it into your database.
5. Configure the project:
   - Edit the `config` files with your database credentials if needed.
6. Launch the application:
   - Open the project in your browser using `http://localhost/`.
   - DB `http://localhost/phpmyadmin/`

---

## Contact
For questions or support, reach out to [artembash@gmail.com](mailto:artembash@gmail.com).



