const pullToRefresh = (trackingCategory) => {
  if (!('serviceWorker' in navigator)) {
    return
  }
  const sendMessageToServiceWorker = (message) => {
  return new Promise((resolve, reject) => {
    const messageChannel = new MessageChannel()
    messageChannel.port1.onmessage = (event) => {
      if (event.data) {
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

  invariant(pullToRefreshElement instanceof HTMLElement)
  invariant(pullToRefreshStatusElement instanceof HTMLElement)
  invariant(pullToRefreshLoaderElement instanceof HTMLElement)
  invariant(pullableContent instanceof HTMLElement)

  const pullToRefreshElementHeight = pullToRefreshElement.offsetHeight
  const pullToRefreshStatusRepository = createPullToRefreshStatusRepository()
  const decelerationFactor = 0.5
  let dragStartPoint = createTouchCoordinates(0, 0)

  const dragUpdate = (dragMovement, pullToRefreshLoaderOpacity) => {
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
  }

  const showPullToRefresh = () => {
    pullToRefreshElement.classList.add('visible-pull')
    pullToRefreshElement.classList.remove('hidden-pull')
  }

  const setRefreshingStatus = () => {
    pullToRefreshStatusElement.innerHTML = ``
    pullToRefreshLoaderElement.classList.add('animate')
  }

  const isPullToRefreshDragCompleted = (yAbsoluteMovement) => yAbsoluteMovement >= pullToRefreshElementHeight

  const setRefreshStatusCompleted = () => {
    pullToRefreshStatusElement.innerHTML = ``
    pullToRefreshElement.classList.add('hidden-pull')
    pullToRefreshElement.classList.add('visible-pull')
  }

  const resetPullToRefreshStatus = () => {
    pullToRefreshStatusElement.innerHTML = ''
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
    }
  }, { passive: false })

  pullToRefreshElement.addEventListener('transitionend', () => {
    if (pullToRefreshStatusRepository.refreshCompleted) {
      window.location.reload()
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
  },
  completeRefresh () {
    this.refreshCompleted = true
  }
})

const invariant = (statement) => {
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

const preventInstallPrompt = async _ => {
    window.addEventListener('beforeinstallprompt', async e => {
        e.preventDefault();
    })
}

const addToHomeScreen = async (button, installPrompt) => {
  if (button) {
    button.setAttribute('disabled', true)
        let beforeInstallPrompt = false
          window.addEventListener('beforeinstallprompt', async (e) => {
            button.disabled = false; // activate Install-Button 
            beforeInstallPrompt = true
              if (installPrompt === '1') {
                  button.style.display= 'block'
                    deferredPrompt = e;
                  } else {
                    e.preventDefault(); 
                  }
              button.addEventListener("click", _ => {
                  button.disabled = true
                  e.prompt() // returned Promise auf undefined
              }, { once: true }) // prompt() darf nur 1x aufgerufen werden
              const { outcome } = await e.userChoice
          })
  }  
  else {
    preventInstallPrompt()
  }
}

const activateCustomInstallButton = async (installPrompt) => {
    const mittPwaInstallButton = document.querySelector('.mittpwa__install__a2hs')
    const mittPwaAndroidInstallButton = document.querySelector('.mittpwa__android__install__a2hs')
     
    if (mittPwaInstallButton) addToHomeScreen(mittPwaInstallButton, installPrompt)

    if (mittPwaAndroidInstallButton) {
      const userAgent = navigator.userAgent.toLowerCase()
      const isAndroid = userAgent.indexOf("android") > -1
      //console.log('isAndroid', isAndroid)
      if  (!isAndroid) {
        mittPwaAndroidInstallButton.parentElement.removeChild(mittPwaAndroidInstallButton)
      }
      addToHomeScreen(mittPwaAndroidInstallButton, installPrompt)
    }

    const userAgent = navigator.userAgent.toLowerCase()
    const isAndroid = userAgent.indexOf("android") > -1
       
    if ((navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1)
            || (navigator.userAgent.indexOf('Mozilla') != -1 && navigator.userAgent.indexOf('Mobile') == -1 && navigator.userAgent.indexOf('Chrome') == -1)
            || (navigator.userAgent.indexOf('Mozilla') != -1 && navigator.userAgent.indexOf('Tablet') == -1 && navigator.userAgent.indexOf('Chrome') == -1)
            && (!isAndroid))
            {
        if (mittPwaInstallButton) mittPwaInstallButton.parentElement.removeChild(mittPwaInstallButton)
              
    } 
}


  
  const isIos = _ => {
        const userAgent = window.navigator.userAgent.toLowerCase()
        //console.log('***userAgent***', userAgent)
        return /iphone|ipad|ipod/.test(userAgent)
    }

    const isPadOs = _ => {
        const userAgentIpadiOs13 = "mozilla/5.0 (macintosh; intel mac os x 10_15_6) applewebkit/605.1.15 (khtml, like gecko) version/14.0 safari/605.1.15" 
        const userAgentIpadiOs14 = "mozilla/5.0 (macintosh; intel mac os x 10_15_6) applewebkit/605.1.15 (khtml, like gecko) version/14.0 safari/605.1.15"
        if (navigator.maxTouchPoints === 0) return
        if (userAgentIpadiOs13 === window.navigator.userAgent.toLowerCase() 
            || userAgentIpadiOs14 === window.navigator.userAgent.toLowerCase()){
            return true
        } 
    }


const activateIosBanner = (settings)=> {

    // Detects if device is in standalone mode
    const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone)
    const iosBannerOwn = document.querySelector('.mittpwa__ios__own_icon')
    if (iosBannerOwn) {
      iosBannerOwn.style.display = 'none'
      if ((isIos() && !isInStandaloneMode() ) || (isPadOs() && !isInStandaloneMode())) iosBannerOwn.style.display = 'block'
    }

    const sessionData = sessionStorage.getItem('mittPwaDismiss')

    if (!sessionData) {
   
        if ((isIos() && !isInStandaloneMode() ) || (isPadOs() && !isInStandaloneMode()))  {

            //show own Banner is setted
          
            // add customMessageInstall

            $iosShareSvg = `<svg class="mittpwa__share_icon" width="1.6em" height="1.6em" viewBox="0 -2 15 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <title>iOs Share</title>
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="share_icon" transform="translate(-1.000000, -2.000000)">
                    <g id="Shape" transform="translate(3.000000, 4.000000)" fill="#000000">
                        <path d="M5.595535,9.163 C5.8475175,9.163 6.0635025,8.96329359 6.0635025,8.71659744 L6.0635025,2.83113205 L6.027505,1.96182179 L6.4234775,2.37298205 L7.31141583,3.30102949 C7.39541,3.39500897 7.51540167,3.44199872 7.62339417,3.44199872 C7.87537667,3.44199872 8.05536417,3.26578718 8.05536417,3.03083846 C8.05536417,2.9133641 8.0073675,2.81938462 7.91137417,2.73715256 L5.93151167,0.869310256 C5.82351917,0.751835897 5.71552667,0.71659359 5.595535,0.71659359 C5.47554333,0.71659359 5.37955,0.751835897 5.25955833,0.869310256 L3.27969583,2.73715256 C3.1837025,2.81938462 3.13570583,2.9133641 3.13570583,3.03083846 C3.13570583,3.26578718 3.31569333,3.44199872 3.55567667,3.44199872 C3.67566833,3.44199872 3.79566,3.39500897 3.87965417,3.30102949 L4.7675925,2.37298205 L5.163565,1.96182179 L5.1275675,2.83113205 L5.1275675,8.71659744 C5.1275675,8.96329359 5.3435525,9.163 5.595535,9.163 Z M2.23576833,13.6622679 L8.95530167,13.6622679 C10.1792167,13.6622679 10.7911742,13.0631487 10.7911742,11.8766577 L10.7911742,6.15565641 C10.7911742,4.96916538 10.1792167,4.38179359 8.95530167,4.38179359 L7.323415,4.38179359 L7.323415,5.29809359 L8.93130333,5.29809359 C9.5192625,5.29809359 9.85523917,5.61527436 9.85523917,6.20264615 L9.85523917,11.8296679 C9.85523917,12.4287872 9.5192625,12.7342205 8.93130333,12.7342205 L2.2477675,12.7342205 C1.65980833,12.7342205 1.33583083,12.4287872 1.33583083,11.8296679 L1.33583083,6.20264615 C1.33583083,5.61527436 1.65980833,5.29809359 2.2477675,5.29809359 L3.867655,5.29809359 L3.867655,4.38179359 L2.23576833,4.38179359 C1.01185333,4.38179359 0.399895833,4.96916538 0.399895833,6.15565641 L0.399895833,11.8766577 C0.399895833,13.0631487 1.01185333,13.6622679 2.23576833,13.6622679 Z"></path>
                    </g>
                    <g id="Artboard1">
                        <rect id="Rectangle" x="0.0382456204" y="0.0468749644" width="16.788834" height="20.9973442"></rect>
                    </g>
                </g>
            </g>
        </svg>`

            const iOsPopUpFragment = document.createDocumentFragment()
            const iOsPopUpContainer = document.createElement('div')
            iOsPopUpContainer.classList.add('mittpwa_ios_notice')

            iOsPopUpContainer.innerHTML = `<svg id="mittpwa__a2hs_icon" width="2.5em" height="2.5em" viewBox="0 0 33 31" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <title>Artboard</title>
            <g  stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" fill-opacity="0">
                <rect   stroke-width="2" fill="#FFFFFF" x="4" y="3" width="25" height="25" rx="3"></rect>
                <line class="mittpwa_a2hs_icon_line" x1="17" y1="9" x2="17" y2="22" id="Line-Copy"  stroke-width="2" fill="#FFFFFF" stroke-linecap="round" transform="translate(17.000000, 15.500000) rotate(90.000000) translate(-17.000000, -15.500000) "></line>
                <line x1="17" y1="9" x2="17" y2="22" id="Line-Copy-2"  stroke-width="2" fill="#FFFFFF" stroke-linecap="round"></line>
            </g>
        </svg>
        <p>${settings.installBannerTextFirstPart} 
        ${$iosShareSvg} ${settings.installBannerTextSecondPart}
        <button class="mittpwa__dismiss"> ${settings.installBannerButtonText} </button></p>`
            iOsPopUpContainer.style.position = 'fixed'

            if (isIos()) {
                iOsPopUpContainer.style.bottom = '0'
            }
            if (isPadOs()) {
                iOsPopUpContainer.style.top = '0'
            }
            iOsPopUpContainer.style.left = '0'
            iOsPopUpContainer.style.zIndex = '10000'
            iOsPopUpContainer.style.backgroundColor = '#fff'
            iOsPopUpContainer.style.width = '100vw'
            iOsPopUpContainer.style.display = 'flex'
            iOsPopUpContainer.style.justifyContent = 'center'
            iOsPopUpContainer.style.alignItems = 'center'
            iOsPopUpContainer.style.fontSize = '1.03rem'
            iOsPopUpContainer.style.lineHeight = '1.65rem'
            iOsPopUpContainer.style.padding = '0.1rem 0.7rem 0.3rem 0.7rem'

            const textParagraph = iOsPopUpContainer.children[1]
            const buttonDismiss = iOsPopUpContainer.querySelector('.mittpwa__dismiss')
            buttonDismiss.style.border = 'none'
            buttonDismiss.style.padding = '0'
            buttonDismiss.style.textAlign = 'unset'
            buttonDismiss.style.backgroundColor = 'unset'
            buttonDismiss.style.fontSize = 'unset'
            buttonDismiss.style.marginTop = '-3px'
            buttonDismiss.style.marginLeft = '5px'
            
            iOsPopUpFragment.appendChild(iOsPopUpContainer)
            
            setTimeout(_ => {
                const bodySite = document.body
                bodySite.appendChild(iOsPopUpFragment)
                
                const add2HomeScreenIcon = document.querySelector('#mittpwa__a2hs_icon')
                const mittpwaShareIcon = document.querySelector('.mittpwa__share_icon')
                const shapeShareIcon = mittpwaShareIcon.querySelector('#Shape')
                
                textParagraph.style.marginLeft = '0.5rem'

                if (isPadOs()) {
                    add2HomeScreenIcon.style.width = '2.0em'
                    add2HomeScreenIcon.style.height = '2.0em'
                    const heightPopUpPad = iOsPopUpContainer.getBoundingClientRect().height
                    bodySite.style.marginTop = heightPopUpPad + 'px'
                }
                
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    iOsPopUpContainer.style.backgroundColor = 'rgb(73,73,73)'
                    iOsPopUpContainer.style.color = 'rgb(255,255,255)'

                    shapeShareIcon.style.fill = 'rgb(10,132,255)'
                    
                    add2HomeScreenIcon.children[0].style.stroke = 'rgb(255,255,255)'
                    add2HomeScreenIcon.children[1].style.stroke = 'rgb(255,255,255)'
                    buttonDismiss.style.color = 'rgb(10,132,255)'
    

                } else {
                    iOsPopUpContainer.style.backgroundColor = 'rgb(209,209,214)'
                    iOsPopUpContainer.style.color = 'rgb(0,0,0)'

                    shapeShareIcon.style.fill  = 'rgb(0,122,255)'

                    add2HomeScreenIcon.children[0].style.stroke = 'rgb(0,0,0)'
                    add2HomeScreenIcon.children[1].style.stroke = 'rgb(0,0,0)'
                    buttonDismiss.style.color = 'rgb(0,122,255)'
                }

                iOsPopUpContainer.addEventListener('click', e => {
                    const target = e.target

                    if (target.matches('button')) {
                        const container = target.parentElement.parentElement
                        container.parentNode.removeChild(container)
                        sessionStorage.setItem('mittPwaDismiss', 'true')
                        bodySite.style.marginTop = '0'
                    }
                

                    if (target.matches('.mittpwa__share_icon')) {

                        const alertType = settings.installBannerAdditionalPopupType

                        if (alertType === 'alert') {
                            alert(`${settings.installBannerAdditionalPopupText1} \n${settings.installBannerAdditionalPopupText2}`)
                        } else if (alertType === 'url') {
                            location = settings.installBannerAdditionalPopupTextUrl
                        }    
                    }
                
                }) 
                
            }, 1000)         
        }
    }
}

const isInWebAppChrome = _ =>  (window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone) || document.referrer.includes('android-app://')
const isInStandaloneMode = _ => ('standalone' in window.navigator && (window.navigator.standalone))


const pullRefresh = body => {
    const pullRefreshFragment = document.createDocumentFragment()
    const pullrefreshContainer = document.createElement('div')

    pullrefreshContainer.classList.add('pull-to-refresh')
    pullrefreshContainer.classList.add('start-pull')
    pullrefreshContainer.classList.add('hidden-pull')
    pullrefreshContainer.setAttribute('id', 'pull-to-refresh')

    body.classList.add('pullable-content')

    pullrefreshContainer.innerHTML = `<div id="pull-to-refresh-loader" class="pull-to-refresh-loader"></div>
    <div id="pull-to-refresh-status" class="pull-to-refresh-status">
        Pull down to refresh
    </div>`
    pullRefreshFragment.appendChild(pullrefreshContainer)
    const bodyChildrens = [...body.children]
    body.insertBefore(pullRefreshFragment, bodyChildrens[0])
    
}

const waitingForSetting = async _ => {
    while (typeof pullRefreshSetting === "undefined") {
      await new Promise(resolve => setTimeout(resolve, 1000));
    }
}

 waitingForSetting()

const wrapperIos = async _ => {
     await waitingForSetting()
     if (isIos() || isPadOs()) {
        const divWrapper = document.createElement("div");
        divWrapper.setAttribute('id', 'mittpwa__wrapper')
        while (document.body.firstChild)
        {
          divWrapper.appendChild(document.body.firstChild);
        }

        document.body.appendChild(divWrapper);
        document.body.style.overflow = 'hidden'
        divWrapper.style.overflow = 'auto'
      }
}
            
document.addEventListener('DOMContentLoaded', async e => {
    const mittPwaInstallButton = document.querySelector('.mittpwa__install__a2hs') 
    const mittPwaAndroidInstallButton = document.querySelector('.mittpwa__android__install__a2hs') 
    const mittPwaBody = document.querySelector('body')
    pullRefresh(mittPwaBody)
   
     if (mittPwaAndroidInstallButton) {
      const userAgent = navigator.userAgent.toLowerCase()
      const isAndroid = userAgent.indexOf("android") > -1
      if  (!isAndroid) {
        console.log('!isAndroid', !isAndroid)
        mittPwaAndroidInstallButton.style.display = 'none'
      }
    }
    
    const waitingForBerforeInstallPromptListener = async _ => {
        while (typeof beforeInstallPrompt === "false") {
          await new Promise(resolve => setTimeout(resolve, 1000));
        }
      }
    
    const disabler = async (button) => {
      await waitingForBerforeInstallPromptListener()
      if (button) {
        const disabledA2hs = button.getAttribute('disabled')
        if (disabledA2hs === 'true') {  
          //button.style.display = 'none' 
        }
      }
    } 
   
     if (isInWebAppChrome() || isInStandaloneMode()) {
        mittPwaBody.classList.add('mittpwa_app_standalone')
        if (mittPwaInstallButton) {
            mittPwaInstallButton.style.display = 'none'
        }
      }

    if (mittPwaInstallButton) disabler(mittPwaInstallButton)
    if (mittPwaAndroidInstallButton) disabler(mittPwaAndroidInstallButton)
   
})



const sendInstallData = async (sendObject) => {
    try {
    const response = await fetch ('index.php?option=com_ajax&plugin=MittPwaPush&format=json', {
            method: 'POST',
            mode: 'same-origin',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(sendObject)
        })

    const json = await response.json();
    return //console.log(json);

    } catch(e){
        console.log(e)
    }
}

const installCounter = (android, ios) => {
    return {
        task: 'countInstallation',
        android: android, 
        ios:  ios
    }
}


window.addEventListener('appinstalled', evt => {
            console.log('appinstalled')            
            sendInstallData(installCounter(1,0))
})


const getIosStandaloneMode = _ => {
    const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);
 
    const appinstalledDataiOS = localStorage.getItem('installedStandaloneMittPWA')
    if (!appinstalledDataiOS) {

        if ((isIos() && isInStandaloneMode() ) || (isPadOs() && isInStandaloneMode()))  {
        sendInstallData(installCounter(0,1))
        localStorage.setItem('installedStandaloneMittPWA', '1')
        }
    }
}

getIosStandaloneMode()



  window.addEventListener('load', async _ => {
    if (pullRefreshSetting === 'on') {
      const trackingCategory = ''
      pullToRefresh(trackingCategory)
      const html = document.querySelector('html')
      html.classList.add('pull__refresh')
    }
    //await wrapperIos()
  })

  
