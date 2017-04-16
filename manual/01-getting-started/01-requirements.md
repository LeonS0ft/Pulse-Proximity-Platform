# Requirements
In order to get started, the [web platform](https://github.com/madewithpepper/Pulse-Proximity-Platform) and [mobile app](https://github.com/madewithpepper/Pulse-Proximity-App) are required.

## Web platform
Administrators log in at the web platform to create content for one or more apps. Content can consist of cards and scenarios.

A card is a location based piece of information, like a store or an event. It has a description, location and optionally an icon and image. Cards are shown in the app and sorted by distance of the user's location.

A scenario is web content triggered by Bluetooth beacons or geo-fences. When a smartphone &dash; with the app installed &dash; enters a certain region (geo-fence), a local push notification can be triggered which opens a web page. Or, when a user has the app open and comes nearby a certain Bluetooth beacon a web page can be opened automatically. These are called scenarios within the context of this project.

Since the platform is multi-user, there can be multiple administrators managing multiple apps with one platform.

## Mobile app
The mobile app is used by end users to view location based information like cards and scenarios, based on the location of the end user's smartphone.

A user can find point of interest nearby, while in the background the app listens to geo-fences and Bluetooth beacons. These can trigger scenarios as described above.