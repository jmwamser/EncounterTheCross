import Countdown from "countdown-tmr";

export default function (querySelector,datasetName) {
    let tickElement = document.querySelector(querySelector);
    let nextEncounterTimeStamp = tickElement.dataset[datasetName];
    // console.log(nextEncounterTimeStamp);
    const options = {
        date: nextEncounterTimeStamp,
        labels: {
            days: 'DAYS',
            hours: 'HOURS',
            minutes: 'MINUTES',
            seconds: 'SECONDS'
        }
    }

    return new Countdown(tickElement, options);
}