// app.js
const express = require('express');
const morgan = require('morgan');
const cookieParser = require('cookie-parser');
const session = require('express-session');
const dotenv = require('dotenv');
const cors = require('cors');
//const { Pool } = require('pg');

// Load environment variables from .env file
dotenv.config();

const app = express();
const port = process.env.PORT || 3000;

// Middleware
app.use(cors()); // Enable CORS for all routes
app.use(morgan('dev')); // HTTP request logging
app.use(cookieParser()); // Parse cookies for session management
app.use(express.json()); // For parsing application/json
app.use(express.urlencoded({ extended: true })); // For parsing application/x-www-form-urlencoded

// Session setup
app.use(
  session({
    secret: process.env.SESSION_SECRET || 'default_secret', // Set a strong session secret in your .env file
    resave: false,
    saveUninitialized: true,
    cookie: { secure: process.env.NODE_ENV === 'production' }, // Use secure cookies in production
  })
);

// PostgreSQL connection setup
/*const pool = new Pool({
  connectionString: process.env.DATABASE_URL, // Use your Supabase or other PostgreSQL database URL
  ssl: { rejectUnauthorized: false }, // Enable SSL for remote databases like Supabase
});

// Test the database connection
pool
  .query('SELECT NOW()')
  .then((res) => console.log('Connected to PostgreSQL:', res.rows[0]))
  .catch((err) => console.error('Error connecting to database', err));

// Example route
app.get('/', (req, res) => {
  res.send('Welcome to HiddenHeavens!');
});
*/

// Example for handling user login route
app.post('/login', (req, res) => {
  const { username, password } = req.body;
  // Here you would validate credentials and create a session for the user
  req.session.user = { username };
  res.send('User logged in');
});

// Basic route
app.get('/', (req, res) => {
    res.send('Welcome to HiddenHeavens!');
  });

// Route for user logout
app.post('/logout', (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      return res.status(500).send('Failed to log out');
    }
    res.send('Logged out');
  });
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
