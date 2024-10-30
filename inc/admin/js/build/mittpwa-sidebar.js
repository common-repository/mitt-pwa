(() => {
  "use strict";
  var e = {
    n: (t) => {
      var a = t && t.__esModule ? () => t.default : () => t;
      return e.d(a, { a }), a;
    },
    d: (t, a) => {
      for (var c in a)
        e.o(a, c) &&
          !e.o(t, c) &&
          Object.defineProperty(t, c, { enumerable: !0, get: a[c] });
    },
    o: (e, t) => Object.prototype.hasOwnProperty.call(e, t),
  };
  const t = window.wp.plugins,
    a = window.wp.editPost,
    c = window.wp.i18n,
    s = window.wp.components,
    i = window.wp.element,
    n = window.wp.data,
    l = window.wp.apiFetch;
  var o = e.n(l);
  const d = {};
  d.mittpwa = (0, i.createElement)(
    "svg",
    {
      id: "uuid-b07d2838-f62b-4360-98e4-f4dee875e1cb",
      class: "custom-icon icon-mittpwa",
      viewBox: "0 0 173.5 232",
    },
    (0, i.createElement)("defs", null),
    (0, i.createElement)(
      "g",
      null,
      (0, i.createElement)("path", {
        id: "uuid-10a7bc13-79e6-4b81-91b0-ec08c6fc31f0",
        class: "uuid-42dd1688-9d36-4fa4-8fa0-c224136e470f",
        d: "M96.14,83.53l31.19-31.15-31.11-31.07,9.71-9.62c3.4-3.37,8.94-3.34,12.31,.05l34.45,34.68c3.37,3.39,3.35,8.92-.05,12.29l-34.72,34.4c-3.4,3.37-8.94,3.34-12.31-.05l-9.47-9.53",
      }),
      (0, i.createElement)("path", {
        class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
        d: "M36.46,21.35h50.82v7.66c0,2.44-1.98,4.42-4.42,4.42H32.04v-7.66c0-2.44,1.98-4.42,4.42-4.42Z",
      }),
      (0, i.createElement)("path", {
        class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
        d: "M22.65,71.42h50.82v7.66c0,2.44-1.98,4.42-4.42,4.42H18.23v-7.66c0-2.44,1.98-4.42,4.42-4.42Z",
      }),
      (0, i.createElement)("path", {
        class: "uuid-20658a14-22ab-4fc7-a1e1-318414975a6a",
        d: "M29.55,47.25h50.82v7.66c0,2.44-1.98,4.42-4.42,4.42H25.13v-7.66c0-2.44,1.98-4.42,4.42-4.42Z",
      })
    ),
    (0, i.createElement)("path", {
      class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
      d: "M140.47,166.04h-18.12c-4,0-7.25,3.24-7.25,7.25v39.85h9v-17.77h16.37v17.77h9v-47.09h-9Zm0,20.32h-16.37v-11.32h16.37v11.32Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
      d: "M18.23,173.28v39.85h9v-17.77h18.12c4,0,7.25-3.24,7.25-7.25v-14.83c0-4-3.24-7.25-7.25-7.25H25.47c-4,0-7.25,3.24-7.25,7.25Zm25.37,13.07H27.23v-11.32h16.37v11.32Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
      d: "M66.18,166.04h1.76v37.95h11.43v-37.95h9v37.95h11.43v-37.95h9v46.95H58.93v-39.7c0-4,3.24-7.25,7.25-7.25Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
      d: "M68.27,154.31h-9.04v-26.76h-11.47v26.76h-9.04v-26.76h-11.47v26.76h-9.04v-28.17c0-4.21,3.41-7.63,7.63-7.63h42.42v35.8Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-20658a14-22ab-4fc7-a1e1-318414975a6a",
      d: "M88.37,118.52v35.8h-9.04v-35.8h9.04Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
      d: "M131.32,116.09h-13.48v38.23h-9.04v-38.23h-13.48v-1.41c0-4.21,3.41-7.63,7.63-7.63h28.38v9.04Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49",
      d: "M150.21,116.09h-5.86v38.23h-9.04v-38.23h-13.48v-1.41c0-4.21,3.41-7.63,7.63-7.63h28.38v1.41c0,4.21-3.41,7.63-7.63,7.63Z",
    }),
    (0, i.createElement)("path", {
      class: "uuid-20658a14-22ab-4fc7-a1e1-318414975a6a",
      d: "M88.37,107.03v9.06h-9.04v-1.43c0-4.21,3.41-7.63,7.63-7.63h1.41Z",
    })
  );
  const r = d,
    u = function (e) {
      const [t, a] = (0, i.useState)([]);
      o()({ path: "mittpwafreewp/v1/topics" }).then((e) => {
        a(e);
      });
      const [c, n] = (0, i.useState)(""),
        l = (e) => {
          console.log("Selected topic:", e), n(e);
        };
      return (0, i.createElement)(
        "div",
        null,
        (0, i.createElement)(
          "form",
          {
            id: "mittpwa_send_push",
            className: "multiplepush",
            action: "",
            encType: "multipart/form-data",
            method: "post",
            onSubmit: (e) => {
              l(e.target.value), e.preventDefault();
              const t = new FormData(e.target);
              t.append("topic", c);
              const a = document.getElementById("post_ID").value;
              console.log("postId", a);
              const s = wp.data.select("core/editor").getCurrentPostType();
              wp
                .apiFetch({
                  path: `/wp/v2/${s}s/${a}?_fields=title,better_featured_image.source_url`,
                })
                .then((e) => {
                  console.log(e),
                    e.better_featured_image &&
                      e.better_featured_image.source_url;
                  const a = wp.data.select("core/editor").getCurrentPost(),
                    s = (a.slug, a.title);
                  wp.apiFetch({
                    path: "mittpwafreewp/v1/send-push-notification",
                    method: "POST",
                    data: {
                      title: s,
                      message: t.get("push_message"),
                      topic: c,
                      link: a.link,
                      post_id: a.id,
                    },
                  })
                    .then((e) => {
                      console.log(e),
                        wp.data
                          .dispatch("core/notices")
                          .createNotice(
                            "success",
                            "miTT PWA FIRE🔥 Push 📲 sent the push message successfully ✅",
                            { isDismissible: !0 }
                          );
                    })
                    .catch((e) => {
                      console.error(e),
                        wp.data
                          .dispatch("core/notices")
                          .createNotice(
                            "error",
                            "Failed to send push notification.",
                            { isDismissible: !0 }
                          );
                    });
                })
                .catch((e) => {
                  console.log(), console.error(e);
                }),
                n("");
            },
          },
          (0, i.createElement)(s.SelectControl, {
            label: "Topic",
            value: c,
            options: [
              { label: "Select a topic", value: "" },
              ...Object.values(t).map((e) => ({ label: e, value: e })),
            ],
            onChange: l,
          }),
          (0, i.createElement)(
            s.Button,
            {
              isPrimary: !0,
              type: "submit",
              onClick: () => console.log("Button clicked"),
            },
            "Send"
          )
        )
      );
    },
    p = (0, n.withSelect)((e) => {
      const { getEditedPostAttribute: t } = e("core/editor");
    })(function (e) {
      return (0,
      i.createElement)(i.Fragment, null, (0, i.createElement)(a.PluginSidebarMoreMenuItem, { target: "mittpwa-sidebar" }, (0, c.__)("Push Messaging", "textdomain")), (0, i.createElement)(a.PluginSidebar, { name: "mittpwa-sidebar", title: (0, c.__)("Push Messaging", "textdomain") }, (0, i.createElement)(s.PanelBody, { title: (0, c.__)("Push Messaging", "textdomain"), initialOpen: !0 }, (0, i.createElement)(u, { ...e }))));
    });
  (0, t.registerPlugin)("mittpwa-sidebar", { render: p, icon: r.mittpwa });
})();
