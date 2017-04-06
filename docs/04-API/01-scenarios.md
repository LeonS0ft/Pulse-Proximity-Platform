# Scenarios

The Pulse Platform `remote` API returns a collection of beacons, geo-fences and scenarios transformed to the UTC timezone. The app posts an API key to retrieve all related data.

## Platform url

The platform url can be configured in the Pulse Ionic 2 app in the file `src/appConfig.ts` with the `platform_url` setting. For example `https://platform.example.com` or `https://example.com`.

## Remote endpoint

The "default" remote endpoint returns the scenarios. All API responses are in JSON format.

**Endpoint:** `/api/v1/remote?token={api_token}`

**Method:** `POST`

### Post parameters

| Parameter | Value |
| - | - |
| token | API token |
| lat | device location latitude |
| lng | device location longitude |
| acc | device location accuracy (used for geolocation correction) |
| uuid | device uuid |
| model | device model |
| platform | device platform (Android, iOS) |

### Platform API response

A response looks like this:

```
{
  "meta": {
    "timezone": "UTC"
  },
  "geofences": [],
  "beacons": [],
  "scenarios": []
}
```