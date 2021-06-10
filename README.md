## Prerequisite
- Docker 2.4 (or latest)
- Docker Compose 1.27.4 (or latest, usually included in docker insall setup)
- Composer 2.0 (or latest)
- Git
- Bash
- Postman (Optional)

### Setup
1. clone repo
```
git clone https://github.com/mugiwaranojem/api_app.git
cd api_app
```
2. Setup the app
```
chmod +x stack.sh
./stack.sh setup
```
it should run the following steps
- BUILDING IMAGES
- SETUP LUMEN
- STARTING CONTAINERS
- RUNNING MIGRATIONS
- LISTING CONTAINERS

### Running the app
1. Run the import script
```
./stack.sh import-customers
```
2. From postman or in browser check enpoint for:  
```
localhost/customers
```

```javascript
{
    "data": [
        {
            "full_name": "Arianna Gilbert",
            "country": "Australia"
        },
        {
            "full_name": "Luis Cooper",
            "country": "Australia"
        },
        {
            "full_name": "Toni Steward",
            "country": "Australia"
        },
        ...
```

```
localhost/customers/2
```
```javascript
{
    "data": {
        "full_name": "Toni Steward",
        "country": "Australia",
        "email": "toni.steward@example.com",
        "username": "organickoala251",
        "gender": "female",
        "city": "Sunshine Coast",
        "phone": "04-3774-8312"
    }
}
```

### Running unit test
```
./stack.sh test
```
> PHPUnit 9.5.5 by Sebastian Bergmann and contributors.  
> ....     4 / 4 (100%)  
> Time: 00:01.946, Memory: 20.00 MB  
> OK (4 tests, 216 assertions)  
