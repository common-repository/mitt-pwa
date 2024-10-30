
const pullToRefresh = (trackingCategory) => {
  if (!('serviceWorker' in navigator)) {
    return
  }

  const sendMessageToServiceWorker = (message) => {
  return new Promise((resolve, reject) => {
    const messageChannel = new MessageChannel()
    messageChannel.port1.onmessage = (event) => {
      if (event.data) {
        console.log(event.data, 'event.data')
        if (event.data.error) {
          reject(event.data.error)
        } else {
          resolve(event.data)
        }
      }
    }
    if (navigator.serviceWorker && navigator.serviceWorker.controller) {
      navigator.serviceWorker.controller.postMessage(message, ([messageChannel.port2]))
    }
  })
}

  const pullToRefreshElement = document.querySelector('#pull-to-refresh')
  const pullToRefreshStatusElement = document.querySelector('#pull-to-refresh-status')
  const pullToRefreshLoaderElement = document.querySelector('#pull-to-refresh-loader')
  const pullableContent = document.querySelector('.pullable-content')
  console.log('pullableContent', pullableContent)

  invariant(pullToRefreshElement instanceof HTMLElement)
  invariant(pullToRefreshStatusElement instanceof HTMLElement)
  invariant(pullToRefreshLoaderElement instanceof HTMLElement)
  invariant(pullableContent instanceof HTMLElement)

  const pullToRefreshElementHeight = pullToRefreshElement.offsetHeight
  const pullToRefreshStatusRepository = createPullToRefreshStatusRepository()
  const decelerationFactor = 0.5
  let dragStartPoint = createTouchCoordinates(0, 0)

  const dragUpdate = (dragMovement, pullToRefreshLoaderOpacity) => {
    console.log('dragUpdate')
    pullToRefreshElement.style.transform = `translateY(${dragMovement}px)`
    pullableContent.style.transform = `translateY(${dragMovement}px)`
    pullToRefreshLoaderElement.style.opacity = `${pullToRefreshLoaderOpacity}`
  }

  const isDraggingForPullToRefresh = (yMovement) => window.scrollY <= 0 && yMovement <= 0

  const closePullToRefresh = () => {
    pullToRefreshElement.classList.add('end-pull')
    pullableContent.classList.remove('end-pull')
    pullToRefreshElement.style.transform = ''
    pullableContent.style.transform = ''
    pullToRefreshLoaderElement.style.opacity = '0'
  }

  const preparePullToRefreshToStart = () => {
    pullToRefreshElement.classList.add('start-pull')
    pullToRefreshElement.classList.remove('end-pull')
    pullableContent.classList.add('start-pull')
    pullableContent.classList.remove('end-pull')
  }

  const showPullToRefresh = () => {
    pullToRefreshElement.classList.add('visible-pull')
    pullToRefreshElement.classList.remove('hidden-pull')
  }

  const setRefreshingStatus = () => {
    pullToRefreshStatusElement.innerHTML = 'Refreshing'
    pullToRefreshLoaderElement.classList.add('animate')
  }

  const isPullToRefreshDragCompleted = (yAbsoluteMovement) => yAbsoluteMovement >= pullToRefreshElementHeight

  const setRefreshStatusCompleted = () => {
    pullToRefreshStatusElement.innerHTML = 'Refresh completed'
    pullToRefreshElement.classList.add('hidden-pull')
    pullToRefreshElement.classList.add('visible-pull')
  }

  const resetPullToRefreshStatus = () => {
    pullToRefreshStatusElement.innerHTML = 'Pull down to refresh'
    pullToRefreshLoaderElement.classList.add('animate')
  }

  document.addEventListener('touchstart', (event) => {
    dragStartPoint = getTouchesCoordinatesFrom(event)
    preparePullToRefreshToStart()
  }, { passive: false })

  document.addEventListener('touchmove', (event) => {
    const dragCurrentPoint = getTouchesCoordinatesFrom(event)
    const yMovement = (dragStartPoint.y - dragCurrentPoint.y) * decelerationFactor
    const yAbsoluteMovement = Math.abs(yMovement)

    if (isDraggingForPullToRefresh(yMovement) && !pullToRefreshStatusRepository.refreshStarted) {
      event.preventDefault()
      event.stopPropagation()
      showPullToRefresh()

      if (isPullToRefreshDragCompleted(yAbsoluteMovement)) {
        pullToRefreshStatusRepository.startRefresh()
        dragUpdate(0, 1)
        setRefreshingStatus()
        sendMessageToServiceWorker({ message: 'refresh', url: window.location.href, }).then(() => {
          pullToRefreshStatusRepository.completeRefresh()
          setTimeout(() => {
            setRefreshStatusCompleted()
            closePullToRefresh()
          }, 1500)
        })
      } else {
        dragUpdate(yAbsoluteMovement - pullToRefreshElementHeight, yAbsoluteMovement / pullToRefreshElementHeight)
      }
    }
  }, { passive: false })

  document.addEventListener('touchend', () => {
    if (!pullToRefreshStatusRepository.refreshStarted) {
      
      closePullToRefresh()
      console.log('closePullToRefresh()')
    }
  }, { passive: false })

  pullToRefreshElement.addEventListener('transitionend', () => {
    if (pullToRefreshStatusRepository.refreshCompleted) {

      window.location.reload()
      console.log('window.location.reload()')
    } else {
      resetPullToRefreshStatus()
    }
  })
}

const createTouchCoordinates = (x, y) => ({ x, y })

const createPullToRefreshStatusRepository = () => ({

  refreshStarted: false,
  refreshCompleted: false,
  startRefresh () {
    this.refreshStarted = true
    console.log('start refresh')
  },
  completeRefresh () {
    this.refreshCompleted = true
  }
})

const invariant = (statement) => {
  console.log(statement)
  if (!statement) {
    throw new Error('Pull to refresh invariant failed')
  }
}

const getTouchesCoordinatesFrom = (event) => {
  return createTouchCoordinates(
    event.targetTouches[0].screenX,
    event.targetTouches[0].screenY
  )
}

export { pullToRefresh }


