*** Settings ***
Library    Browser

*** Comments ***
Validate that the Login.html Form navigates to the correct page after clicking the on the login button

*** Tasks ***
Validate Login Form
    Open Browser
    Fill out input fields
    Click login button
    Validate correct navigation

*** Variables ***
${correct_navigation_url}    file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/index.html
${passwort}    passwort

*** Keywords ***
Open Browser
    New Browser    browser=chromium    headless=False
    New Context
    New Page    url=file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Login.html

Fill out input fields
    Type Text    selector=id=benutzername    txt=benutzername    delay=0.1
    Type Secret    selector=id=passwort    secret=$passwort

Click login button
    Click    selector=id=login_button

Validate correct navigation
    ${current_url}=    Get Url
    Should Be Equal    ${current_url}    ${correct_navigation_url}
