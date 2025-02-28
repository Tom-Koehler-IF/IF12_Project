*** Settings ***
Library    Browser

*** Comments ***
Validates that the Register.html form navigates to the Login.html form if the button "Zurück zur, Anmeldung" is clicked.

*** Tasks ***
Validate Login Form
    Open Browser
    Navigate to Login From
    Validate correct navigation 

*** Variables ***
${correct_navigation_url}    file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Login.html

*** Keywords ***
Open Browser
    New Browser    browser=chromium    headless=False
    New Context
    New Page    url=file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Register.html

Navigate to Login From
    Click    selector=id=navigate_to_login_form

Validate correct navigation
    ${current_url}=    Get Url
    Should Be Equal    ${current_url}    ${correct_navigation_url}