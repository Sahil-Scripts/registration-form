# Hosting on Vercel + External Database

You requested to host this PHP application on Vercel. Since Vercel is a **Serverless** platform (it doesn't have a persistent server or database), we need a specific setup.

## 1. The Setup (Already Done)
I have added a `vercel.json` file to your project. This tells Vercel how to process your PHP files.
I have also updated your PHP files to read database credentials from **Environment Variables** (standard cloud practice) instead of hardcoded strings.

## 2. The Database Problem
Vercel **does not** host databases. It only hosts the code.
You need a separate MySQL database.
**Recommendation:** Use **Railway.app** (it has a trial/free tier and is very easy) or **Aiven.io**.

## 3. Step-by-Step Deployment Guide

### Phase 1: Get a Cloud Database (e.g., Railway)
1. Go to [Railway.app](https://railway.app/) and sign up.
2. Click **New Project** -> **Provision MySQL**.
3. Once created, click on the **MySQL** card -> **Variables**.
4. You will see variables like `MYSQLHOST`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`, `MYSQLPORT`. Keep this tab open.
5. **Important:** You need to create your table.
   - Click **Data** tab in Railway (or use a tool like TablePlus/HeidiSQL to connect using the credentials).
   - Copy the content of `database_setup.sql` from your project and run it in the database console to create the `students` table.

### Phase 2: Deploy Code to Vercel
1. Upload your code to **GitHub**.
2. Go to [Vercel.com](https://vercel.com/) and sign up.
3. Click **Add New ...** -> **Project**.
4. Import your GitHub repository.
5. **Crucial Step:** In the "Configure Project" screen, find **Environment Variables**.
6. Add the variables from your Cloud Database (Phase 1):
   - `MYSQLHOST` = (Value from Railway)
   - `MYSQLUSER` = (Value from Railway)
   - `MYSQLPASSWORD` = (Value from Railway)
   - `MYSQLDATABASE` = (Value from Railway)
   - `MYSQLPORT` = (Value from Railway, usually 3306 or similar)
7. Click **Deploy**.

## 4. Verification
Once deployed, Vercel will give you a URL (e.g., `registration-form.vercel.app`).
- Open it.
- Try submitting a form.
- It should save to your Cloud Database.
