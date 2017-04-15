# Create scenarios

In order to test Bluetooth beacons or geo-fences, you need to follow the steps below. These steps require you to have the platform installed with a corresponding app.

## Create app
First, we need to create an API token for the app. Log in to the platform and go to `Mobile > Apps`. Click the `New app` button and enter a name for the app. An API token is generated, but you can change it.

This API token needs to be entered in the app (`src/appConfig.ts`). Now you can compile the app with the API token, and the app will listen to all campaigns using the app associated with this token.

## Add a beacon or geo-fence
To test a scenario, we need at least one beacon or geo-fence. You can manage those at `Mobile > Beacons` and `Mobile > Geofences`. 

## Create campaign
Now we can create a campaign at `Mobile > Campaigns`. Click the `New campaign` button, enter a name for the campaign and select the app created in the previous step.

## Edit scenarios
After the campaign has been created, you can click the `Edit scenarios` link. The scenarios screen will open where you can click `Add scenario` to add scenarios the app will listen to. Every time the app is opened on the mobile phone, it retrieves the latest scenarios from the platform API.