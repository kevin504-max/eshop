### Overview
This is a documentantion for the "Eshop" application. The project is an e-commerce system, developed entirely in Laravel,
with functionalities for administrators and users. Administrators have access to a dashboard where they can manage products,
categories, view user details and purchase history. Ordinary users can preview products, add items to the shopping cart
by specifying the quantity, and add products to the wishlist.
The system supports payments via PayPal, Razorpay and cash on delivery (COD). The project is available at `https://eshop-production-4f4b.up.railway.app/` and includes a command to populate the database with products using the `php artisan import-products` command.

### Technologies Used
* Backend:
    * Laravel: A PHP framework used for backend development.
    * MySQL: Relational database used to store application data.

* Frontend:
    * HTML: Markup language for structuring the user interface.
    * CSS: Styling language used to style the user interface.
    * JavaScript: Programming language used to add interactivity to the user interface.
    * Bootstrap: A CSS framework used to create responsive layouts and component styling.

* Payments:
    * PayPal: An online payment service used to process electronic payments.
    * Razorpay: An online payment platform offering simplified payment services.
    * Cash on Delivery (COD): Payment on delivery option, where payment is made upon delivery of the product.

### Installation and Configuration
To run the project locally, follow the steps below:

1. Clone the project repository:
```bash
git clone https://github.com/kevin504-max/eshop.git
```
2. Install the Composer dependencies:
```bash
composer install
```
3. Create the .env environment file based on the .env.example file and configure the database.
4. Generate the application encryption key:
```bash
php artisan key:generate 
```
6. Run database migrations:
```bash
php artisan migrate
```
7. (Optional) Populate the database with products - Ensure that you have at least one category registered to be linked:
```bash
php artisan import-products
```
8. Start the development server:
```bash
php artisan serve
npm run dev
```

### Application Usage
Access the application in your browser and use the following features:

* Administration
    * Log in to the admin panel with your admin credentials.
    * From the admin panel, you can:
        * Perform CRUD (Create, Read, Update, Delete) operations on products and categories.
        * View user details.
        * View purchase history and details.

    * Common Users
        * Browse the products available in the store.
        * Add items to the shopping cart, specifying the desired quantity.
        * Add products to wishlist to save them for future purchases.
        * Select a payment method: PayPal, Razorpay or COD (cash on delivery).
