Feature: CanUpdateParticipentStatus
  In order to update an event participant
  As a team 2 leader
  I need to be able to see the event status actions

  Background:
    Given I am logged in as a Leader

  Scenario Outline: Event Participants Actions On List Page
    Given I am on the "<object_type>" "List" Page
    When I click on the action row menu
    And I see "detail" action
    And I see "edit" action
    And I click the "show_registrations" action
    And I click on the action row menu
    Then I should see a "<action>" action

    Examples:
      | object_type | action         |
      | Events      | mark_dup       |
      | Events      | mark_drop      |

#  Scenario Outline: Restrict Deletion Actions On List Page
#    Given I am on the "<object_type>" "List" Page
#    When I click on the action row menu
#    And I see "detail" action
#    And I see "edit" action
#    And I click the "show_registrations" action
#    And I click on the action row menu
#    And I click the "mark_drop" action
#    And I click on the action row menu
#    Then I should see a "<action>" action
#
#    Examples:
#      | object_type | action         |
#      | Events      | mark_attending |