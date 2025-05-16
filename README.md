# بطاقة تعريفية لإرشاد التائهين (Lost Pilgrims Guide Card)

This is a responsive identification card designed to help guide lost pilgrims. It contains contact information for supervisors, hotel details, and the Mutawwif (pilgrim guide) information.

## Features

- Responsive design that works on mobile devices
- Bilingual support (Arabic/English) with language toggle
- Contact information with direct call and WhatsApp links
- Hotel locations with Google Maps integration
- Clean, modern UI with Bootstrap
- Centralized data management in JavaScript

## Usage

Simply open the `index.html` file in any modern web browser. The identification card will load with Arabic as the default language. You can toggle between Arabic and English using the language button at the top of the card.

## Customization

To customize the information on the card:

1. Edit the `script.js` file to update all data in the `appData` object:
   - Supervisor contact information
   - Hotel GPS coordinates
   - Mutawwif (pilgrim guide) contact information 

2. Update translations in the `translations` object in the `script.js` file:
   - Text labels in both Arabic and English
   - Hotel names and addresses
   - Button labels

This unified approach allows you to manage all data in one place without having to modify the HTML directly.

## Technical Details

- Built with HTML5, CSS3, and JavaScript
- Uses Bootstrap 5 for responsive layout
- Font Awesome for icons
- Supports RTL and LTR text directions 