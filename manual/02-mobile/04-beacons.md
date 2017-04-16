# Beacons
With "beacons" we refer to Bluetooth Low Energy (BLE) devices that broadcast the iBeacon protocol. They're also called iBeacon or Bluetooth beacons.

## Manage beacons
In the web platform you can add, remove or update beacons at `Mobile > Beacons`. Each beacon requires a name, UUID, a major and a minor. The UUID of a beacon is the unique identifier which is set by the vendor and can be changed with the vendor's app. Usually you can request a UUID you prefer when you order a large quantities of beacons.

The major and minor values are numeric values to differentiate between beacons with the same UUID. These can also be changed with the app of the vendor. A common practice is to use the major value to identify a venue, and the minor value a spot at this venue. 

> In some cases the UUID of a beacon is case sensitive.