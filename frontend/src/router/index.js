import { createRouter, createWebHistory } from 'vue-router'
import ListRemindersView from '../views/ListRemindersView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: ListRemindersView
    },
    {
      path: '/calendario',
      name: 'calendar',
      component: () => import('../views/CalendarRemindersView.vue')
    },
    {
      path: '/lembrete/adicionar',
      name: 'add-reminder',
      component: () => import('../views/CalendarRemindersView.vue')
    }
  ]
})

export default router
