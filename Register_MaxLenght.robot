*** Settings ***
Library    Browser

*** Comments ***
Validate that the Register.html form allows a maximum of [number] characters for [input field]

*** Tasks ***
Validate Login Form
    Open Browser
    Validate Vorname
    Validate Nachname
    Validate Postleitzahl
    Validate Ort
    Validate Straße
    Validate Hausnummer
    Validate Benutzername
    Validate Passwort

*** Variables ***
${31char_validate_string}    1234567890123456789012345678901    # 31 characters
${30char_validate_string}    123456789012345678901234567890    # 30 characters

${6char_validate_string}    123456    # 6characters
${5char_validate_string}    12345    # 5characters

${41char_validate_string}    12345678901234567890123456789012345678901    # 41 characters
${40char_validate_string}    1234567890123456789012345678901234567890    # 40 characters

${4char_validate_string}    1234    # 4characters
${3char_validate_string}    123    # 3characters

*** Keywords ***
Open Browser
    New Browser    browser=chromium    headless=False
    New Context
    New Page    url=file:///C:/Users/tomr/Documents/Schule/Projekt/Website/HTML/Register.html

Validate Vorname
    Type Text    selector=id=vorname_register    txt=${31char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=vorname_register
    Should Be Equal    ${vorname_value}    ${30char_validate_string}

Validate Nachname
    Type Text    selector=id=nachname_register    txt=${31char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=nachname_register
    Should Be Equal    ${vorname_value}    ${30char_validate_string}

Validate Postleitzahl
    Type Text    selector=id=postleitzahl_register    txt=${6char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=postleitzahl_register
    Should Be Equal    ${vorname_value}    ${5char_validate_string}

Validate Ort
    Type Text    selector=id=ort_register    txt=${41char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=ort_register
    Should Be Equal    ${vorname_value}    ${40char_validate_string}

Validate Straße
    Type Text    selector=id=strasse_register    txt=${41char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=strasse_register
    Should Be Equal    ${vorname_value}    ${40char_validate_string}

Validate Hausnummer
    Type Text    selector=id=hausnummer_register    txt=${4char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=hausnummer_register
    Should Be Equal    ${vorname_value}    ${3char_validate_string}

Validate Benutzername
    Type Text    selector=id=benutzername_register    txt=${31char_validate_string}    delay=0.1
    ${vorname_value}=    Get Text    selector=id=benutzername_register
    Should Be Equal    ${vorname_value}    ${30char_validate_string}

Validate Passwort
    Type Secret    selector=id=passwort_register    secret=$31char_validate_string    delay=0.1
    ${vorname_value}=    Get Text    selector=id=passwort_register
    Should Be Equal    ${vorname_value}    ${30char_validate_string}