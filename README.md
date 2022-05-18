Google Cloud Function triggered by Pub/Sub message being sent on certain topic.

This function is simple example of cloud function with Pub/Sub trigger type which send message to Slack channel via webhook. 

We will use test slack channel `test-webshop-cf` to test how this function works.

Runtime: PHP

### Guidebook to run this function
1. Clone this repo
```
git clone git@github.com:lemon57/cloud-function-pubsub-msg-slack-php.git
```
2. Define Slack webhook url in `config.php`. You can find this webhook -> [Slack channel webhook](https://api.slack.com/apps/A03FHHA7URG/incoming-webhooks?).
3. Deploy this function to GC. Wait a few min ☕
```
gcloud functions deploy <CF_NAME> \
     --trigger-resource <PUB_SUB_TOPIC_NAME> \
     --trigger-event google.pubsub.topic.publish \
     --region=<REGION_NAME> \
     --runtime=<CF_RUNTIME>
```
Replace `PUB_SUB_TOPIC_NAME` by your topic name. Define your own.
Replace `REGION_NAME` by region of current project.
Replace `CF_RUNTIME` by actual runtime, in our case is `PHP74`.
4. Check that the function deployed successfully: by command or through GCC UI.
```
gcloud functions describe <CF_NAME> --region=<REGION_NAME>
```
5. Invoke function directly by command:
```
gcloud functions call <CF_NAME> --data '{"data":"R29vZ2xlIGNsb3VkIGZ1bmN0aW9uIHdvcmtzaG9w"}'
```
This string `R29vZ2xlIGNsb3VkIGZ1bmN0aW9uIHdvcmtzaG9w` base64 encoded. You can create your specific message. Make it base64 encoded, use this resource [base64encode](https://www.base64encode.org/)

or by sending message to certain topic by command:
```
gcloud pubsub topics publish projects/<PROJECT_NAME>/topics/<PUB_SUB_TOPIC_NAME> --message Hello
```
Replace `PROJECT_NAME` by our current boozt project name.
Replace `PUB_SUB_TOPIC_NAME` by topic name which you just recently created. Or you can always find needed topic name by:
```
gcloud pubsub topics list | grep <KEY_WORD_OF_YOUR_TOPIC_NAME>
```

6. Check the logs:
```
gcloud functions logs read --execution-id=<EXECUTION-ID> --region=<REGION_NAME>
```
Take `EXECUTION_ID` from the output after executing these commands: `gcloud functions call` or `gcloud pubsub topics publish`.

6. Check slack channel `test-webshop-cf`

Enjoy 🎆