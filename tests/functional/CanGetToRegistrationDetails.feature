Feature: CanGetToRegistrationDetails
  As a Leader
  I want to get to a list of registrations for an event
  So that I know who all will be attending

  Background:
    Given I am logged in as a Leader

  Scenario: Get to Event Registration Details from Events List page
    Given I am on the "Events" "List" Page
    When I click on the action menu for an "Events"
    And I should see a "Show Registrations" action
    And I click the "Show Registrations" action
    Then I see
#    Then
#    Then I should see Form Field label of "Name"
#    And I should see Form Field label of "Start"
#    And I should see Form Field label of "Registration Dead Line Servers"
#    And I should see Form Field label of "Location"
#    And I should see Form Field label of "Launch Points"
#    And I should see Form Field label of "Price"
#    And I should see Form Field label of "Total Servers"
#    And I should see Form Field label of "Total Attendees"
#    And I should see Form Rows of "Registrations"

#  Scenario: Get to Event Registration Details from Dashboard