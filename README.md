Hello,
today we are going to build a school management App with Laravel and FilamentPHP v3 "MySchool.com"
using :
- Laravel
- FilamentPHP V3


Part 01: Laravel Installation

	- [x] Laravel Installation
		-> [x] Laravel configuration
		-> [x] Install some helpers [juststeveking/launchpad, Pint, nunomaduro/larastan]
		-> [x] Update users table and User Model
		-> [x] Update User factory an UserSeeder
		-> [x] Create admins table and Admin Model
		-> [x] Create Admin factory an AdminSeeder
		-> [x] Configure the admin and User authGuard

Part 02: Filament Installation

	- [x] FilamentPHP v3 Installation
		-> [x] Installation
		-> [x] Add some plugins
	- [x] Costumize filament
		-> [x] police font
		-> [x] Logo
		-> [x] favicon
		-> [x] Colors
		-> [x] DarkMode
		-> [x] Filament Theme
	-[x] Filament Panel
		-> [x] Create a school and Teacher Panel
		-> [x] Costumize panels
		-> [x] Multiple AuthGuard

Part 03: Filament Auth System

	-[x] Filament Auth Systhem
		-> [x] Extend Profile for each panel let move it to our index panel
		-> [x] Add image profile to admin and users
		-> [x] Extend Login for each panel to log with phone or email()
		-> [x] Extend Register for school panel let's do a sam thing

Part 04: Update the Auth System
        
     ->[x] Update the Auth System
        -> [x] Create Role model -mfs
        -> [x] Create a RoleSeeder
        -> [x] Create a RoleResource make panel id desabled i want to generate the role from the system
        -> lets creat an action to generate our role from the system
        -> [x] Create a UserResource
        -> [x] Update The login Teacher and School: i wan to check if the user has This panel before sign
        -> [x] Update The Register School: let's do a same thing`

Part 05: Notifications

    - [x] Add Filament notification to our application
    - [x] Create an Observer for user model
    - [x] Create notification for user->school
    - [x] Create notification for admin when the school->user register

Part 06: Update Resources

    - [x] UserResource navigation
    - [x] Add Tabs
    - [x] Create the Admin Resource and customize it
    - [x] Add image to table ->UserResource and Admin Resource

Part 07: School Resource

    - [] Create a School model
    - [] UserResource navigation customize it
    - [] Create middleware that redirects the user to the school creation page if it has not yet been created
    - [] Add classes to school
    - [] Create education_level, and grades tables
    - [] Create a SchoolResource for the school panel and the admin panel

Part 08: Create a JobResource

    - [] Create a jobs table
    - [] Create a JobResource ->admin panel
    - [] update the UserResource Admin panel
        system of assigning users to schools
    - [] create the UserResource school panel
        system of assigning users to schools

Part 09:


Thanks to watching this video to see you tomorrow