# Hidden Heavens Platform Documentation

Welcome to the comprehensive documentation for the Hidden Heavens platform. This document outlines the pricing plans, database schema, file structure, setup instructions, and key features of the platform in detail, aimed at providing a clear understanding of its functionality and potential for stakeholders.

---

## Platform Overview

**Hidden Heavens** connects users with businesses through listings, blogs, and reviews. The platform allows businesses to showcase their offerings while providing users with a personalized browsing experience. Key components include:

1. **Listings**: Businesses can list their services or products with detailed descriptions, images, and pricing.
2. **Reviews**: Users can leave feedback and ratings on listings.
3. **Blogs**: Content focused on food-related topics, enhancing user engagement.
4. **Bookmarks**: Allows users to save listings for later reference.
5. **Pricing Plans**: Monetizes the platform by offering tiered plans for businesses.

---

## Pricing Plans

The pricing plans are structured to cater to businesses of varying scales and needs, providing features that align with their growth goals.

### **1. Basic Plan (R100/month)**
**Target Audience**: Small businesses or startups testing the platform.

**Features:**
- **Visibility**: Low placement in search results.
- **Images Allowed**: 3 images per listing.
- **Social Links**: Not enabled.
- **Analytics**: Not available.
- **Featured Placement**: Not available.
- **Discounts for Multiple Listings**: None.

**Use Case**:
A small takeaway shop that wants a simple listing with minimal exposure to test the platform's reach.

---

### **2. Standard Plan (R300/month)**
**Target Audience**: Established businesses aiming for a standard presence.

**Features:**
- **Visibility**: Medium placement in search results.
- **Images Allowed**: 5 images per listing.
- **Social Links**: Enabled for platforms like Facebook and Instagram.
- **Analytics**: Not available.
- **Featured Placement**: Not available.
- **Discounts for Multiple Listings**: 5% per additional listing.

**Use Case**:
A mid-sized cafe looking to attract local customers with detailed descriptions, images, and social media integration.

---

### **3. Premium Plan (R650/month)**
**Target Audience**: Businesses looking to dominate their local market.

**Features:**
- **Visibility**: High placement in search results.
- **Images Allowed**: 10 images per listing.
- **Social Links**: Enabled.
- **Analytics**: Provides reports on listing views, clicks, and bookmarks.
- **Featured Placement**: Highlighted on category pages.
- **Discounts for Multiple Listings**: 10% per additional listing.

**Use Case**:
A popular restaurant that wants to track user interactions and stand out in search results.

**Implementation:**
Analytics are powered by an event tracking system. Each listing interaction (view, bookmark, or review) is logged in the database for monthly reporting.

---

### **4. Elite Plan (R950/month)**
**Target Audience**: High-end businesses or franchises.

**Features:**
- **Visibility**: Maximum placement, including homepage features.
- **Images Allowed**: Unlimited.
- **Social Links**: Enabled.
- **Analytics**: Detailed reports and insights.
- **Featured Placement**: Prominent placement on the homepage and newsletters.
- **Priority Support**: Dedicated customer support.
- **Discounts for Multiple Listings**: 20% per additional listing.

**Use Case**:
A premium grill house or nightclub aiming for maximum exposure and detailed analytics to refine marketing strategies.

---

## Database Schema and Explanations

The database schema is designed to ensure seamless integration between users, listings, reviews, blogs, and more.

### **1. Users Table**
**Purpose**: Stores user information.

| Column       | Description                                  |
|--------------|----------------------------------------------|
| `id`         | Unique identifier for each user.            |
| `username`   | Display name for the user.                  |
| `email`      | Contact email for login and communication.  |
| `password`   | Encrypted password.                         |
| `user_type`  | Defines user type (`normal` or `listing`).   |
| `status`     | Tracks user status (active, inactive, locked).|

**Relationships**:
- Linked to `listings` via `user_id`.
- Linked to `reviews` and `bookmarks` for user activity.

---

### **2. Categories Table**
**Purpose**: Organizes content into categories.

| Column       | Description                                      |
|--------------|--------------------------------------------------|
| `id`         | Unique identifier for each category.            |
| `name`       | Name of the category (e.g., `Fast Food`).       |
| `type`       | Classifies the category (`food`, `listing`, `blog`).|

**Example:**
- **Food Categories**: `Fast Food`, `Hidden Gems`, `Grill & BBQ`.
- **Blog Categories**: `Travel`, `Food Reviews`.

---

### **3. Listings Table**
**Purpose**: Stores details of business listings.

| Column          | Description                                       |
|-----------------|---------------------------------------------------|
| `id`            | Unique identifier for each listing.              |
| `user_id`       | Links the listing to its owner.                  |
| `category`      | Category of the listing (e.g., `food`).          |
| `gallery`       | JSON storing image URLs (minimum 3 images).      |
| `pricing_plan_id`| Links to the chosen pricing plan.               |

**Features:**
- **Gallery**: Stores visual content.
- **Opening Hours**: JSON object defining daily operating times.
- **Social Links**: Adds value for higher-tier plans.

---

### **4. Pricing Plans Table**
**Purpose**: Defines tiered plans for monetization.

| Column         | Description                                    |
|----------------|------------------------------------------------|
| `id`           | Unique identifier for each plan.              |
| `name`         | Name of the pricing plan (e.g., `Basic`).      |
| `price`        | Monthly cost of the plan.                     |
| `discount_rate`| Discount for multiple listings.               |
| `features`     | JSON object defining plan features.           |

---

### **5. Reviews Table**
**Purpose**: Captures user feedback for listings.

| Column       | Description                                     |
|--------------|-------------------------------------------------|
| `id`         | Unique identifier for each review.             |
| `listing_id` | Links the review to a specific listing.         |
| `user_id`    | Links the review to the author.                |
| `rating`     | Integer rating from 1 (worst) to 5 (best).      |
| `comment`    | Text feedback.                                 |

**Use Case**:
- A listing displays its average rating and user reviews dynamically.

---

## File Structure and Placement for Developers

To ensure a smooth development workflow, here is the recommended file structure and the purpose of each directory:

### **Frontend**
- **`index.php`**: The main landing page for the platform.
- **`contact-us.php`**: Contains the contact form.
- **`css/`**: Stores stylesheets for the platform.
  - **`style.css`**: Primary stylesheet.
  - **`bootstrap/`**: Bootstrap framework files.
- **`js/`**: Contains JavaScript files.
  - **`custom.js`**: Custom scripts for platform interactivity.
  - **`jquery.min.js`**: jQuery library.

### **Backend**
- **`php/`**: Stores all backend scripts.
  - **`auth/`**: Authentication-related scripts (login, registration, etc.).
  - **`contact-form.php`**: Handles contact form submissions.
  - **`resend_verification.php`**: Resends email verification.
  - **`db.php`**: Centralized database connection file.
  - **`email_config.php`**: Configurations for sending emails.

### **Assets**
- **`images/`**: Stores all images used in the platform.
  - **`logo.svg`**: Platform logo.
  - **`bg/`**: Background images for different sections.

### **Components**
- **`header.php`**: Contains the navigation menu.
- **`footer.php`**: Contains the footer section.

### **Database Scripts**
- **`migrations/`**: SQL files for database setup.
  - **`users.sql`**: Creates the `users` table.
  - **`listings.sql`**: Creates the `listings` table.
  - **`reviews.sql`**: Creates the `reviews` table.
  - **`pricing_plans.sql`**: Populates pricing plan data.

---

## Setup Instructions

To set up the Hidden Heavens platform, follow these steps:

### **1. Environment Setup**
- Install PHP (v7.4 or higher) and MySQL.
- Set up a local server environment using tools like XAMPP, WAMP, or Laragon.
- Install Composer for dependency management.

### **2. Database Configuration**
- Import the provided database scripts from the `migrations/` folder.
  ```bash
  mysql -u root -p your_database_name < migrations/users.sql
  mysql -u root -p your_database_name < migrations/listings.sql
  mysql -u root -p your_database_name < migrations/reviews.sql
  mysql -u root -p your_database_name < migrations/pricing_plans.sql
  ```
- Update the `db.php` file with your database credentials:
  ```php
  $host = 'localhost';
  $dbname = 'hidden_heavens';
  $username = 'root';
  $password = '';
  ```

### **3. Dependency Installation**
- Run the following command to install required libraries:
  ```bash
  composer install
  ```

### **4. File Permissions**
- Ensure the `images/` folder has write permissions for file uploads.
  ```bash
  chmod -R 775 images/
  ```

### **5. Starting the Server**
- Start the built-in PHP server:
  ```bash
  php -S localhost:8000
  ```
- Access the platform at `http://localhost:8000`.

### **6. Email Configuration**
- Update `email_config.php` with your SMTP credentials:
  ```php
  $mail->Host = 'smtp.mailtrap.io';
  $mail->Username = 'your_username';
  $mail->Password = 'your_password';
  ```
- Test email functionality by registering a new user.

---

## Visual Representation

![Database Schema](./EnhancedDatabaseSchema.png)

---

## Conclusion

The Hidden Heavens platform offers robust features for users and businesses, enabling seamless interaction through listings, blogs, and reviews. The tiered pricing system ensures scalability and profitability while meeting diverse user needs. For further details or customizations, contact the development team.

