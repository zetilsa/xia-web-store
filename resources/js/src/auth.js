import { reactive } from "vue";

export const authState = reactive({
  isAuth: !!localStorage.getItem("token"),
});
