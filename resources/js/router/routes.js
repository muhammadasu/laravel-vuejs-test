export default [
  {
    path: "/",
    name: "home",
    component: () => import("../components/Properties"),
  },
  {
    path: "/edit-property/:id",
    name: "edit-property",
    component: () => import("../components/AddProperty"),
  },
  {
    path: "/add-property",
    name: "add-property",
    component: () => import("../components/AddProperty"),
  },
  
  // { path: "*", component: () => import("../views/pages/utility/error-404") },
];
