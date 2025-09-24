# Changelog

All notable changes to this project will be documented in this file.

## [1.3.3] - 2024-06-20

### Added
- CSS classes for block padding/margin spacing
- CSS classes for making an <img> tag a background image

## [1.3.2] - 2024-06-19

### Added
- Function added to disable Contact Form 7 submit button after form is submitted to avoid double submissions
- Function to change Contact Form 7 submit button from input to button form type

## [1.3.1] – 2024-04-20

### Fixed
- Sanity check the shop_manager role exists before attempting to add capabilities
- Moved  to the WooCommerce override file

## [1.3.0] – 2024-03-29

### Added
- Images will presume to be lazily loaded by default for wp_get_attachment_image() and get_the_post_thumbnail()
- Shop manager role can now paste iframes into the WYSIWYG

### Changed
- Bootstrap 5 is default for Understrap
- Removed Understrap references from functions.php

### Removed
- Removed Understrap override file, placed in wp-overrides.php


## [1.2.0] – 2023-10-13

### Added
- Added override functions
	- Enable shortcodes on text widgets
	- Disable Site Health widget and menu link
	- Remove WordPress version appearing in the <head>
	- Remove list of usernames from WordPress REST API endpoint
	- Enable more user roles to edit the WordPress privacy policy page
	- Prevent Contact Form 7 from wrapping elements automatically in a paragraph

### Removed
- FontAwesome font files and style files

## [1.1.0] – 2023-09-18

### Added
- Custom Post Types
	- Reviews
	- Team Members
	- Case Studies

- Added icon fonts

Social icons:
- TikTok
- X
- Facebook (square)
- Facebook
- Instagram
- Youtube
- Linkedin (square)
- Linkedin
- Pinterest

Credit Cards icons:
- Visa
- Mastercard
- Discovery
- American Express
- PayPal
- Stripe
- Apple Pay
- Google Pay

Other icons:
- Share

## [1.0.0] - 2023-09-04

### Added
- Includes Bootstrap v5.2.2
- Includes Understrap v1.2.2
- Includes initial file structure of Understrap

## [1.0.1] - 2024-03-29

### Changed
- Purged Understrap naming from functions.php
