import "./assets/js/nav-pills.js";
import "./assets/scss/argon-dashboard.scss";

// Import all Argon components
import ArgonAlert from "./components/ArgonAlert.vue";
import ArgonInput from "./components/ArgonInput.vue";
import ArgonSnackbar from "./components/ArgonSnackbar.vue";
import ArgonTextarea from "./components/ArgonTextarea.vue";
import ArgonSwitch from "./components/ArgonSwitch.vue";
import ArgonSocialButton from "./components/ArgonSocialButton.vue";
import ArgonRadio from "./components/ArgonRadio.vue";
import ArgonProgress from "./components/ArgonProgress.vue";
import ArgonPaginationItem from "./components/ArgonPaginationItem.vue";
import ArgonPagination from "./components/ArgonPagination.vue";
import ArgonCheckbox from "./components/ArgonCheckbox.vue";
import ArgonButton from "./components/ArgonButton.vue";
import ArgonBadge from "./components/ArgonBadge.vue";
import ArgonAvatar from "./components/ArgonAvatar.vue";

export default {
  install(app) {
    // Register all Argon components globally
    app.component('ArgonAlert', ArgonAlert);
    app.component('ArgonInput', ArgonInput);
    app.component('ArgonSnackbar', ArgonSnackbar);
    app.component('ArgonTextarea', ArgonTextarea);
    app.component('ArgonSwitch', ArgonSwitch);
    app.component('ArgonSocialButton', ArgonSocialButton);
    app.component('ArgonRadio', ArgonRadio);
    app.component('ArgonProgress', ArgonProgress);
    app.component('ArgonPaginationItem', ArgonPaginationItem);
    app.component('ArgonPagination', ArgonPagination);
    app.component('ArgonCheckbox', ArgonCheckbox);
    app.component('ArgonButton', ArgonButton);
    app.component('ArgonBadge', ArgonBadge);
    app.component('ArgonAvatar', ArgonAvatar);
  },
};
