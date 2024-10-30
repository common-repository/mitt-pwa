import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { PluginSidebarMoreMenuItem } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import {
  TextControl,
  CheckboxControl,
  PanelBody,
  Button,
  SelectControl,
  FormToggle,
} from "@wordpress/components";
import { useState } from "@wordpress/element";
import {
  useDispatch,
  withSelect,
  withDispatch,
  useSelect,
} from "@wordpress/data";
import { createElement } from "@wordpress/element";
import { Fragment } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";
import icons from "./icons.js";

const MittpwaSendPush = function (props) {
  const [topics, setTopics] = useState([]);
  apiFetch({ path: "mittpwafreewp/v1/topics" }).then((fetchedTopics) => {
    setTopics(fetchedTopics);
  });

  const [selectedTopic, setSelectedTopic] = useState("");

  const onTopicSelect = (topic) => {
    console.log("Selected topic:", topic);
    setSelectedTopic(topic);
  };

  const onSubmit = (event) => {
    onTopicSelect(event.target.value);
    event.preventDefault();

    const formData = new FormData(event.target);
    formData.append("topic", selectedTopic);

    // Get the post title and image using the REST API
    const postId = document.getElementById("post_ID").value;
    console.log("postId", postId);

    const currentPostType = wp.data.select("core/editor").getCurrentPostType();

    wp.apiFetch({
      path: `/wp/v2/${currentPostType}s/${postId}?_fields=title,better_featured_image.source_url`,
    })
      .then((post) => {
        console.log(post);
        const image = post.better_featured_image
          ? post.better_featured_image.source_url
          : "";

        const currentPost = wp.data.select("core/editor").getCurrentPost();
        const slug = currentPost.slug;

        const title = currentPost.title;

        wp.apiFetch({
          path: "mittpwafreewp/v1/send-push-notification",
          method: "POST",
          data: {
            title: title,
            topic: selectedTopic,
            link: currentPost.link,
            post_id: currentPost.id,
          },
        })
          .then((response) => {
            console.log(response);
            wp.data
              .dispatch("core/notices")
              .createNotice(
                "success",
                "miTT PWA FIRE🔥 Push 📲 sent the push message successfully ✅",
                {
                  isDismissible: true,
                }
              );
          })
          .catch((error) => {
            console.error(error);
            wp.data
              .dispatch("core/notices")
              .createNotice("error", "Failed to send push notification.", {
                isDismissible: true,
              });
          });
      })
      .catch((error) => {
        console.log();
        console.error(error);
      });
    setSelectedTopic("");
  };

  return (
    <div>
      <form
        id="mittpwa_send_push"
        className="multiplepush"
        action=""
        encType="multipart/form-data"
        method="post"
        onSubmit={onSubmit}
      >
        <SelectControl
          label="Topic"
          value={selectedTopic}
          options={[
            { label: "Select a topic", value: "" },
            ...Object.values(topics).map((topic) => ({
              label: topic,
              value: topic,
            })),
          ]}
          onChange={onTopicSelect}
        />
        <Button
          isPrimary
          type="submit"
          onClick={() => console.log("Button clicked")}
        >
          Send
        </Button>
      </form>
    </div>
  );
};

const MittpwaSidebar = withSelect((select) => {
  const { getEditedPostAttribute } = select("core/editor");
})(function (props) {
  return (
    <Fragment>
      <PluginSidebarMoreMenuItem target="mittpwa-sidebar">
        {__("Push Messaging", "textdomain")}
      </PluginSidebarMoreMenuItem>
      <PluginSidebar
        name="mittpwa-sidebar"
        title={__("Push Messaging", "textdomain")}
      >
        <PanelBody
          title={__("Push Messaging", "textdomain")}
          initialOpen={true}
        >
          <MittpwaSendPush {...props} />
        </PanelBody>
      </PluginSidebar>
    </Fragment>
  );
});

registerPlugin("mittpwa-sidebar", {
  render: MittpwaSidebar,
  icon: icons.mittpwa,
});
