#############################################################
##             🆆🅴🅻🅲🅾🅼🅴 🅣🅞 ⒸⒹⓁⓅ !                  ##
#############################################################

## Presentation

This application is dedicated to managing an apartment reservation schedule. 
Its aim is to inform the person in charge of check-out of each new reservation, and the owner of each new departure.
 
## Getting Started

### Prerequisites

1. Check composer is installed

### Install

1. Clone this project.
2. Run `composer install`.
3. Create a file `.env.local` in root and configure it according to the .env pattern by declaring all the variables.
4. Configure an SMTP server.
5. configure your own database. then :
- run the command `symfony console d:d:d --force` and then `symfony console d:d:c` to check if the database is correctly linked
- run the command `symfony console d:m:m` to generate the tables in your database
- run `symfony server:start` to launch your local php web server
6. WARNING : at first, modify the security.yaml file to allow access to everyone. Then, create an administrator. And finaly, reinstate the authorizations.


## Versioning

the Bêta version 1.0 has been deployed in september,2023

## Author

- Sébastien Violante

########################### MEMO FOR FURTHER USES #####################
The delay between now and the client's arrivalDate or departureDate needs to create a customed function with Twig.
To do that :
- run bin/console make:twig-extention and call it eg AppExtension
