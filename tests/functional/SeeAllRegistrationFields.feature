Feature: SeeAllRegistrationFields
  As a Leader
  I want to get to the details of a registration for an event
  So that I know all the details for each person

  Background:
    Given I am logged in as a Leader
    And I have a new "Event"

  Scenario: try Viewing an Attendee
    Given I have a new "Attendee"
    And I am on the "Events" "List" Page
    And I click on the action menu for an "Events"
    And I should see a "Show Registrations" action
    And I click the "Show Registrations" action
    When I click on the action row menu
    And I click the "Show" action
    Then I should see Form Field label of "First Name"
    And I should see Form Field label of "Last Name"
    And I should see Form Field label of "Email"
    And I should see Form Field label of "Phone"
    And I should see Form Field label of "Address"
    And I should see Form Field label of "Address 2"
    And I should see Form Field label of "City"
    And I should see Form Field label of "State"
    And I should see Form Field label of "Zip"
    And I should see Form Field label of "Contact Person"
    And I should see Form Field label of "Relationship"
    And I should see Form Field label of "Launch Point"
    And I should see Form Field label of "Invited By"
    And I should see Form Field label of "Church"
    And I should see Form Field label of "Concerns"
    And I should see Form Field label of "Questions or Comments"
    And I should see Form Field label of "Attending Status"
    And I should see Form Field label of "Paid"
    And I should see Form Field label of "Payment Method"

  Scenario: try Viewing a Server
    Given I have a new "Server"
    And I am on the "Events" "List" Page
    And I click on the action menu for an "Events"
    And I should see a "Show Registrations" action
    And I click the "Show Registrations" action
    When I click on the action row menu
    And I click the "Show" action
    Then I should see Form Field label of "First Name"
    And I should see Form Field label of "Last Name"
    And I should see Form Field label of "Email"
    And I should see Form Field label of "Phone"
    And I should see Form Field label of "Address"
    And I should see Form Field label of "Address 2"
    And I should see Form Field label of "City"
    And I should see Form Field label of "State"
    And I should see Form Field label of "Zip"
    And I should see Form Field label of "Launch Point"
    And I should see Form Field label of "Served Times"
    And I should see Form Field label of "Concerns"
    And I should see Form Field label of "Questions or Comments"
    And I should see Form Field label of "Attending Status"
    And I should see Form Field label of "Paid"
    And I should see Form Field label of "Payment Method"