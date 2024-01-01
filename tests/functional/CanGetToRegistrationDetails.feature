Feature: CanGetToRegistrationDetails
  As a Leader
  I want to get to a list of registrations for an event
  So that I know who all will be attending

  Background:
    Given I am logged in as a Leader

  Scenario: Get to Event Registration Details from Events List page
    Given I am on the "Events" "List" Page
    When I click on the action row menu
    And I should see a "Show Registrations" action
    And I click the "Show Registrations" action
    Then I should be on "Event Participants" "List" Page

#  Scenario: Get to Event Registration Details from Dashboard