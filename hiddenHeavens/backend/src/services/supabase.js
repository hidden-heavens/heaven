// src/services/supabase.js
const { createClient } = require('@supabase/supabase-js');

// Access environment variables
const supabaseUrl = process.env.STAG_SUPABASE_URL;
const supabaseKey = process.env.STAG_SUPABASE_KEY;

// Function to create and export the Supabase client
const supabase = createClient(supabaseUrl, supabaseKey);

module.exports = supabase;
