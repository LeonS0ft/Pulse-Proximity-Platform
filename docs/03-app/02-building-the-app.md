# Building the app

This app targets iOS and Android. Download it here: [https://github.com/madewithpepper/Pulse-Proximity-App](https://github.com/madewithpepper/Pulse-Proximity-App).

## Installation
After you've downloaded the project, open the `config.xml` in the root and update the name, app id and version. Then, navigate to the root directory with your CLI.

### Install required NPM packages

``` bash
$ npm install
```

### Add Ionic dirs

``` bash
$ ionic serve
```

### Add plugins

``` bash
$ ionic plugin add cordova-plugin-statusbar cordova-plugin-splashscreen cordova-plugin-device cordova-sqlite-storage cordova-plugin-geolocation cordova-plugin-geofence cordova-plugin-ibeacon cordova-plugin-safariviewcontroller de.appplant.cordova.plugin.local-notification cordova-plugin-network-information --save
```

``` bash
$ npm install @ionic/storage ng2-translate moment-timezone @ionic-native/status-bar @ionic-native/splash-screen @ionic-native/device @ionic-native/sqlite @ionic-native/geolocation @ionic-native/geofence @ionic-native/ibeacon @ionic-native/safari-view-controller @ionic-native/local-notifications @ionic-native/network --save
```

### iOS

Add the following keys to the project's Info.plist:

> <key>NSCameraUsageDescription</key>
> <string>Used to scan QR codes</string>

> <key>NSLocationAlwaysUsageDescription</key>
> <string>Used to provide information based on the device location</string>

> <key>NSBluetoothPeripheralUsageDescription</key>
> <string>Used to receive Bluetooth Beacon signals</string>

### Add platforms
For iOS developers, take a look at the [Cordova iOS Platform Guide](https://cordova.apache.org/docs/en/latest/guide/platforms/ios/) and follow the instructions to install or upgrade X Code, and possibly register for a developer account to start building apps for iOS.

For Android developers, take a look at the [Cordova Android Platform Guide](https://cordova.apache.org/docs/en/latest/guide/platforms/android/) and follow the instructions to install the SDK and/or Android Studio to start building apps for Android.
