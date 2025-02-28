*** Settings ***
Library    Browser

*** Comments ***
Validate that the Login.html form allows a maximum of [number] characters for [input field]

*** Tasks ***
Validate Login Form
    Open Browser
    Validate Username
    Validate Password

*** Variables ***
${31char_validate_string}    1234567890123456789012345678901    # 31 characters
${30char_validate_string}    123456789012345678901234567890    # 30 characters


*** Keywords ***
Open Browser
    New Browser    browser=chromium    headless=False
    New Context
    New Page    url=file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Login.html

Validate Username
    Type Text    selector=id=benutzername    txt=${31char_validate_string}    delay=0.1
    ${username_value}=    Get Text    selector=id=benutzername
    Should Be Equal    ${username_value}    ${30char_validate_string}   # 30 characters

Validate Password
    Type Secret    selector=id=passwort    secret=$31char_validate_string    delay=0.1
    ${password_value}=    Get Text    selector=id=passwort
    Should Be Equal    ${password_value}    ${30char_validate_string}    # 30 characters
