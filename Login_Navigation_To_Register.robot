*** Settings ***
Library    Browser

*** Comments ***
Validates that the Login.html form navigates to the Register.html form if the button "Noch keinen Account, HIER klicken" is clicked.

*** Tasks ***
Validate Login Form
    Open Browser
    Navigate to Register From
    Validate correct navigation 

*** Variables ***
${correct_navigation_url}    file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Register.html

*** Keywords ***
Open Browser
    New Browser    browser=chromium    headless=False
    New Context
    New Page    url=file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Login.html

Navigate to Register From
    Click    selector=id=navigate_to_register_form

Validate correct navigation
    ${current_url}=    Get Url
    Should Be Equal    ${current_url}    ${correct_navigation_url}