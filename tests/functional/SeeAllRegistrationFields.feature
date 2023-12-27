Feature: SeeAllRegistrationFields
  As a Leader
  I want to get to the details of a registration for an event
  So that I know all the details for each person

  Background:
    Given I am logged in as a Leader
    And I have a new "Event"

  Scenario: try Viewing an Attendee
    Given I have a new "Attendee"
    When I am on the new "Attendee" Detail Page
    Then I should see Form Field label of "Full Name"
    And I should see Form Field label of "Email"
    And I should see Form Field label of "Phone"
    And I should see Form Field label of "Address"
    And I should see Form Field label of "Address 2"
    And I should see Form Field label of "City"
    And I should see Form Field label of "State"
    And I should see Form Field label of "Zipcode"
    And I should see Form Field label of "Contact Person"
    And I should see Form Field label of "Contact Relationship"
    And I should see Form Field label of "Contact Phone"
    And I should see Form Field label of "Launch Point"
    And I should see Form Field label of "Invited By"
    And I should see Form Field label of "Church"
    And I should see Form Field label of "Concerns"
    And I should see Form Field label of "Questions or Comments"
#    And I should see Form Field label of "Attending Status"
    And I should see Form Field label of "Paid"
    And I should see Form Field label of "Payment Method"

  Scenario: try Viewing a Server
    Given I have a new "Server"
    When I am on the new "Server" Detail Page
    Then I should see Form Field label of "Full Name"
    And I should see Form Field label of "Email"
    And I should see Form Field label of "Phone"
    And I should see Form Field label of "Address"
    And I should see Form Field label of "Address 2"
    And I should see Form Field label of "City"
    And I should see Form Field label of "State"
    And I should see Form Field label of "Zipcode"
    And I should see Form Field label of "Launch Point"
    And I should see Form Field label of "Server Attended times"
    And I should see Form Field label of "Health Concerns"
    And I should see Form Field label of "Questions or Comments"
#    And I should see Form Field label of "Attending Status"
    And I should see Form Field label of "Paid"
    And I should see Form Field label of "Payment Method"