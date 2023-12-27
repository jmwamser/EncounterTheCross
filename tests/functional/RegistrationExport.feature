Feature: RegistrationExport
  As a Leader
  I want to be able to export registration of an event
  So that I can plan out the event

  Background:
    Given I am logged in as a Leader

  Scenario: Export Registration List Sorted by Launch Point From Events Page
    Given I am on the "Events" "List" Page
    And I click on the action row menu
    And I see "Export by Launch" action
    When I click and download the "Export by Launch" action
    Then I receive the xlsx file
    And I verify there are tabs

  Scenario: Export Registration List From Events Page
    Given I am on the "Events" "List" Page
    And I click on the action row menu
    And I see "Export All" action
    When I click and download the "Export All" action
    Then I receive the xlsx file
    And I verify there are not tabs
