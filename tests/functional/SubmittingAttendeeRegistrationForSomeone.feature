Feature: SubmittingAttendeeRegistrationForSomeone
  As a Server
  I want to sign up my attendee with my email
  So that I know they are signed up by dont have to have their email

  Background:
    Given I have a new "Event"
    And I have a new "Attendee" with email "a@a.com"

  Scenario: Submitting Attendee Registration For Someone Using my email
    # Given I fill out attendee registration form, use same email and random name
    Given I am on an Event "Attendee" registration
    And I fill out registration with "Attendee" info
    And I fill out registration attendee email with "a@a.com"
    # When i submit registration
    When I submit registration
    Then I should see "Thank You" page
    # Then I should have 2 persons in database with email "a@a.com" but different full names
    And I should have 2 "persons" in database with different "FullName"
