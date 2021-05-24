### Current Version: 3.3.2
---

# Getting Started
Just submodule this repo into the wp-content folder (wp-content/languages)
```
git submodule add git@bitbucket.org:24dotcom/tf-languages.git wp-content/languages
```
Then go to the sites **General Settings** and set the language to **af_ZA**

---

## Modifying Translations
1. MAKE SURE YOU GET THE LATEST CODE FROM THE MASTER BRANCH FIRST
1. open the **af_ZA.po** file in the root with poEdit
1. Click on the **Source text** you want to change
1. Amend the existing translation in the **Translation** box
1. Save the file
1. Install node packages
    - ``npm install``
1. run the grunt task in the languages folder
    - ``grunt``
    - this will copy files to the necessary locations
    
---

## Adding Translations
1. MAKE SURE YOU GET THE LATEST CODE FROM THE MASTER BRANCH FIRST
1. The main file you need to pay attention to is languages.php
1. You will see that there are arrays of strings in this file
    - text domains used in all our WordPress sites are ``twentyfourdotcom``
    - although for this translation file to work, no text domains are needed
    - it just works out the box
1. Add you new **ENGLISH** text that needs to be translated in one of the arrays
    - e.g. if you want to add translate the word **Search**
    - add ``__('Search')`` to any of the arrays
    - NOTE: translations are case sensitive
    - So it's safer to add 3 entries for each text you want to translate
    - Uppercase, lowercase, and the standard format
    - e.g. ``__('SEARCH')`` and ``__('search')`` and ``__('Search')``
1. Open up the **af_ZA.po** file with poEdit
1. Make sure the properties of the file are configured correctly
    - Catalog > Properties
    - Click the **Sources paths** tab
    - Paths = "."
    - Excluded paths = "node_modules/"
    - Click the **Sources keywords** tab
    - Additional keywords should include **_e** AND **__**
1. Update the file from the sources
    - Catalog > Update from Sources
1. The new entries in the **languages.php** file should be detected now
1. Add the translated text in the **Translation** box for each new entry
1. Once you're done, save the file
1. Navigate to the languages root folder in your terminal
    - ``cd wp-content/languages``
1. Install node packages
    - ``npm install``
1. Run grunt
    - ``grunt``
1. Test your translations
1. Commit and push your changes

---

# Upcoming 
1. grunt to look for all translatable text in the themes folder and automatically populate the languages.php file
