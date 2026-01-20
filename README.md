# Expense Tracker

A simple expense tracker application built with **Laravel**, **Inertia.js**, and **Vue 3**.  
The app allows users to add income and expenses, manage entries with CRUD operations, and automatically calculate totals and balance.

---

## 🚀 Features

- Add income and expense records
- Edit and delete transactions
- Automatic calculation of:
  - Total income
  - Total expenses
  - Current balance
- User authentication
- Clean and simple UI
- Full-stack monolithic architecture (no separate API)

---

## 🛠 Tech Stack

- **Backend:** Laravel
- **Frontend:** Vue 3
- **Adapter:** Inertia.js
- **Build Tool:** Vite
- **Database:** MySQL
- **Authentication:** Laravel Breeze

---

## 📂 Project Structure (Key Parts)

```text
app/
 └── Http/Controllers
resources/
 └── js/Pages
     └── Transactions
routes/
 └── web.php
database/
 └── migrations
