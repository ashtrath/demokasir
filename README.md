# SINVENTO
## SINVENTO is Effortless Store Management 

### Simple, Smart, and Powerful
Take control of your store with an app designed for simplicity and efficiency. Whether you’re a small shop owner or managing a larger retail space, our app provides the essential tools you need—without the complexity.

### Main Features
- **Built-in Cashier**: Process sales directly within the app, making transactions quick and hassle-free.
- **Monthly Report**: Don't take your time to create a bunch of reports of transactions, just one click and the reports are ready to see.
- **Complete Inventory Control**: Manage categories, track items, and monitor sales effortlessly—all in one place.
- **Data at a Glance**: View real-time charts, track daily revenue, and check total items in a simple, intuitive dashboard.
- **Flexible Discount System**: Offer discounts with ease—apply in purchases.
- **Optional Member System**: Create customer accounts to manage loyalty or rewards, with no sign-up required. Just create the customer

### Upcoming Features
- Thinking


Simplicity doesn’t have to mean limited functionality. Our app gives you the tools you need, without the clutter. It's everything you need to keep your store running smoothly, with the power to scale.

### How To Use
First download or clone this project with
```
git clone https://github.com/IqroNegoro/SINVENTO.git
cd sinvento
```
Then install it package
```
composer install
npm install
```
Rename .env file and changed the database or something that you should change
```
.env.example -> .env 
```
Generate new key, migrate fresh database with the seed and link the storage
```
php artisan key:generate
php artisan migrate:refresh --seed
php artisan storage:link
```
And enjoy
```
php artisan serve
npm run dev
```

### Default User
- **Username** : admin
- **Password** : admin
