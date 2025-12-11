# Hosting the Entire App on Railway

Railway is excellent for this because it can host **both** your Website (PHP) and your Database (MySQL) in one place.

## Step 1: Prepare your Code (Done)
I have added a `composer.json` file. This tells Railway, "Hey, I am a PHP application!"

## Step 2: Push to GitHub
1.  Upload/Push your code to your GitHub repository.

## Step 3: Create Project on Railway
1.  Go to [Railway.app](https://railway.app/) and Log in.
2.  Click **+ New Project** -> **GitHub Repo**.
3.  Select your `registration-form-main` repository.
4.  Click **Deploy Now**.
    *   *Railway will start building your website container.*

## Step 4: Add the Database
1.  In your Railway project view, click the **+ New** button (top right or on the canvas).
2.  Select **Database** -> **MySQL**.
3.  It will add a MySQL card to your project.
4.  Wait for it to initialize (green checkmark).

## Step 5: Connect Website to Database
1.  Click on your **Website** card (the PHP app).
2.  Go to the **Variables** tab.
3.  Click **New Variable** (or "Add Reference").
4.  You don't need to copy-paste! Because they are in the same project, Railway lets you "Reference" them.
    *   For `MYSQLHOST`, type `${{MySQL.MYSQLHOST}}`
    *   For `MYSQLUSER`, type `${{MySQL.MYSQLUSER}}`
    *   For `MYSQLPASSWORD`, type `${{MySQL.MYSQLPASSWORD}}`
    *   For `MYSQLDATABASE`, type `${{MySQL.MYSQLDATABASE}}`
    *   For `MYSQLPORT`, type `${{MySQL.MYSQLPORT}}`
    *   *Note: If "Add Reference" is tricky, you can just manually copy the values from the MySQL card's "Variables" tab and paste them here.*

## Step 6: Create the Table
1.  Click on the **MySQL** card.
2.  Click the **Data** tab.
3.  You will see a "Command" or "Query" area, or a button to "Create Table".
4.  Copy the code from your `database_setup.sql` file.
5.  Run it to create the `students` table.

## Step 7: Done!
*   Railway gives your website a public URL (found in the Website card -> Settings -> Networking).
*   Open that URL. Your site is live and connected to the database!
