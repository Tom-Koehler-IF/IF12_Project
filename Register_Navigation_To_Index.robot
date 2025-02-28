*** Settings ***
Library    Browser

*** Comments ***
Validate that the Register.html Form navigates to the correct page after clicking the on the register button

*** Tasks ***
Validate Login Form
    Open Browser
    Fill out input fields
    Click register button
    Validate correct navigation

*** Variables ***
${correct_navigation_url}    file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/index.html
${Passwort}    Passwort

*** Keywords ***
Open Browser
    New Browser    browser=chromium    headless=False
    New Context
    New Page    url=file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Register.html

Fill out input fields
    Type Text    selector=id=vorname_register    txt=Vorname    delay=0.1
    Type Text    selector=id=nachname_register    txt=Nachname    delay=0.1
    Type Text    selector=id=postleitzahl_register    txt=12345    delay=0.1
    Type Text    selector=id=ort_register    txt=Ort    delay=0.1
    Type Text    selector=id=strasse_register    txt=Strasse    delay=0.1
    Type Text    selector=id=hausnummer_register    txt=123    delay=0.1
    Type Text    selector=id=benutzername_register    txt=Benutzername    delay=0.1
    Type Secret    selector=id=passwort_register    secret=$Passwort    delay=0.1

Click register button
    Click    selector=id=register_button

Validate correct navigation
    ${current_url}=    Get Url
    Should Be Equal    ${current_url}    file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/index.html