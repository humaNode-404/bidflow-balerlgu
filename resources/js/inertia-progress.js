import { router } from "@inertiajs/vue3"
import NProgress from "nprogress"

let timeout = null

router.on("start", () => {
  timeout = setTimeout(() => NProgress.start(), 250)
})

router.on("progress", event => {
  if (NProgress.isStarted() && event.detail.progress.percentage) {
    NProgress.set((event.detail.progress.percentage / 100) * 0.9)
  }
})

router.on("finish", event => {
  clearTimeout(timeout)
  if (!NProgress.isStarted()) {
    return
  } else if (event.detail.visit.completed) {
    NProgress.done()
  } else if (event.detail.visit.interrupted) {
    NProgress.set(0)
  } else if (event.detail.visit.cancelled) {
    NProgress.done()
    NProgress.remove()
  }
})
