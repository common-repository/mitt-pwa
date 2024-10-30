
importScripts("'{importScriptPathSW}'localforage/1.10.0/localforage.min.js")

//TODO: scope variable

let appBadgeUnreadCount = 0



const version = '{serviceworker_version}'
const hash = '{serviceworker_randomstring}'




const staticCacheName = version + '_staticFiles'
const pageCacheName = 'pages'
const imgCacheName = 'images'
const webfontCacheName = 'webfonts'
const consoleLogNumber = 1

const getAppBadgeCount = async _ => {
  try {
    return await localforage.getItem('appBadgeCount')
  } catch (err) {
    console.log(err);
  }
}

const getAppBadgeUrls = async _ => {
  try {
    return await localforage.getItem('appBadgeUrls')
  } catch (err) {
    console.log(err);
  }
}



const urlsToPrefetch = [
  '{staticFiles}'
];

const fetchCdn = async (cache, urlsToPrefetch) => {
  for (let index = 0; index < urlsToPrefetch.length; index++) {
    const reqUrl = await new Request(urlsToPrefetch[index], { mode: 'no-cors' })
    
      fetch(reqUrl).then(response => cache.put(reqUrl, response));
    
  }
}

const cacheFiles = async _ => {
  const cache = await caches.open(staticCacheName)

  if ('{valueOfDebugMode}' === '1') console.log('👷🏻‍♀️ CacheVersionControl ',staticCacheName)
  try {
    if ('{valueOfCdn}' === '0') await cache.addAll(['{staticFiles}'])
    if ('{valueOfCdn}' === '1') await fetchCdn(cache, urlsToPrefetch)
  } catch (error){
    console.log('Cache Add Static Files Error 🧰⭕️', error)
  }
}

const cleanCacheVersion = async _ => {
  try {
  const cacheKeys = await self.caches.keys()
  const toDelete = cacheKeys.filter((key) => key !== staticCacheName)
  return Promise.all(toDelete.map((key) => {

    if ('{valueOfDebugMode}' === '1') console.log('cacheKeyDelete ✅', key)
    self.caches.delete(key)
    })
  )
  } catch (error){
    console.log('cacheDeleteError 🚫', error)
  }
}

const cacheMatch = async (request) => {
  try {
    const url = request.url
    const cleanUrl = url.split('?')
    const cacheMatch = await caches.match(cleanUrl[0])
    if (cacheMatch) {
      return cacheMatch
    }
    //avoid admin error page
    if (request.mode === 'navigate' && request.url.includes('administrator')) {
      return
    }
    return false 
  } catch (error) {
    console.log('chacheMatch', error)
  }
}


const uriExceptions = (uri, response) => {
  return new Promise((resolve, reject) => {
    const urlCacheExceptions = ['{cachePageExceptions}']
    let exception
    urlCacheExceptions.forEach(urlCacheException => {
      if (uri.includes(urlCacheException)) {
        exception = true
      }   
    }) 
    !exception
      ? resolve('please clone')
      : reject(new Error('uriException', 'This page wont be cloned to cache' ))
  })
}

const respondTo = async(e) => {
  try {
    
    // If Post Request load from network
    if (e.request.method !== 'GET' && e.request.ok) {
      if ('{valueOfDebugMode}' === '1') console.log('early Returned Post Request')
      return e.request
    }

    let cacheFirst = '{valueOfCacheFirst}'
    const settedNetwork = parseInt('{valueOfNetworkConnection}')

    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    if ('{valueOfDebugMode}' === '1') console.log('connection', connection)

    const effectiveNetwork = (!connection) ? '4g' : connection.effectiveType
    if ('{valueOfDebugMode}' === '1') console.log('effectiveNetworkConnection', effectiveNetwork)

    const chacheFirstNetwork = (effectiveNetwork, settedNetwork) => {
      let numberNetwork
     
      if (effectiveNetwork === '4g') numberNetwork = 4
      if (effectiveNetwork === '3g') numberNetwork = 3
      if (effectiveNetwork === '2g') numberNetwork = 2
      if (effectiveNetwork === 'slow-2g') numberNetwork = 1

      if (settedNetwork >= numberNetwork) {
        if ('{valueOfDebugMode}' === '1') console.log('chacheFirsteffectiveNetwork', '1')
        return cacheFirst = '1'
      } else {
        if ('{valueOfDebugMode}' === '1') console.log('chacheFirsteffectiveNetwork', '0')
        return cacheFirst = '0'
      }
    }

    if (effectiveNetwork || settedNetwork === '0') {
      const resultNetworkCache = chacheFirstNetwork(effectiveNetwork, settedNetwork)
    }

    const cachedResponse = await cacheMatch(e.request)
    const response = await fetch(e.request)

    if (response.ok) {   
      
      if ('{valueOfCdn}' === '1') {
      if (e.request.url.match(/\.(jpe?g|png|gif|svg|webp)$/)
        && response.url.includes('administrator') === false) {
        const reqUrl = new Request(e.request.url, { mode: 'no-cors' })
        const cache = await self.caches.open(imgCacheName)
        fetch(reqUrl).then(response => cache.put(reqUrl, response));
      }
    }
      if (e.request.headers.get('Accept').includes('text/html')
        && response.url.includes('administrator') === false) {
        
        if('setAppBadge' in navigator && 'clearAppBadge' in navigator) {

            const badgeLinks = await getAppBadgeUrls()
              if (badgeLinks === null) {
                  navigator.clearAppBadge()
                  localforage.setItem('appBadgeCount', 0)
                  localforage.setItem('appBadgeUrls', [])
              } 
              
              const badgeCount = await getAppBadgeCount()
              let count = 0
              const newBadgeLinks = badgeLinks

              badgeLinks.forEach(item => {
                  const url  = new URL(item)
                  const path = url.pathname

                  if (response.url.includes(url.pathname)){
                    newBadgeLinks.splice(/*index*/1, count)
                    localforage.setItem('appBadgeUrls', newBadgeLinks)
                    localforage.setItem('appBadgeCount', badgeCount - 1)
                    navigator.setAppBadge(badgeCount - 1)
                  }
              count++
              })
        }
        

         await uriExceptions(response.url, response)
          const cache = await self.caches.open(pageCacheName)
          if(e.request)
          cache.put(e.request, response.clone())
      }


     if (response.url.match(/\.(jpe?g|png|gif|svg|webp)$/)) {
         const cache = await self.caches.open(imgCacheName)
         if(e.request.method !== 'DELETE') {
          cache.put(e.request, response.clone())
         } else {
          cache.delete(response.url)
         }
      }

      if (e.request.url.match(/\.(woff|eot|woff2|ttf)$/) 
        && response.url.includes('administrator') === false) {
        if ('{valueOfDebugMode}' === '1') console.log('Webfont Request ✏️', e.request.url)
        if (e.request.url.includes('gstatic')) {
          const reqUrlGoogle = new Request(e.request.url)
          const cache = await self.caches.open(webfontCacheName)
          if(['http:', 'https:'].includes(reqUrlGoogle)) {
            fetch(reqUrlGoogle).then(response => cache.put(reqUrlGoogle, response));
          }
        }
        
        const reqUrlWebfont = new Request(e.request.url)
        const cache = await self.caches.open(webfontCacheName)
        if(['http:', 'https:'].includes(reqUrlWebfont)) {
            if ('{valueOfDebugMode}' === '1') {
              console.log('Intern-Font', e.request)
            }
            cache.put(e.request, response.clone())
        }
      }

    }
    
    if (cachedResponse && cacheFirst === '1') {
      if ('{valueOfDebugMode}' === '1') console.log('🗃 📲 Cache First (PWA)')
      if ('{valueOfDebugMode}' === '1') console.log('Response from Cache 🗃',cachedResponse, )
      return cachedResponse

    } else {
      if ('{valueOfDebugMode}' === '1') console.log('📡 📲 Network First (PWA)')
      return response

    } 
  } catch (error) {
    console.log('EM',error.message)
    if (error.message === 'uriException') {
      const response = await fetch(e.request)
      return response
    } 
  
    try {
       const responseFromCache = await cacheMatch(e.request)
        if (responseFromCache){
        return responseFromCache
      } else {
          return caches.match('/inc/frontend/offline.html')
      }
    } catch (error){
      return caches.match('/inc/frontend/offline.html')
    }
  }
}


self.addEventListener('install', e => {
  try {
    self.skipWaiting()
    
    console.log(`🛠 PWA - ServiceWorker ⚙️ install ✅`)
  } catch (error) {
    throw new Error('🛠 PWA Install Error 🚫 ', error)
  }
})

self.addEventListener('activate', e => {
  e.waitUntil(cleanCacheVersion())
})

self.addEventListener('fetch', e => {
    if (e.request.method === 'POST') return
  
    const url = new URL(e.request.url)
    const pathAndQuery = url.pathname + url.search
    const valueOfDebugFetchRequest = '{valueOfDebugFetchRequest}'
    const valueOfDebugRequestException = '{valueOfDebugRequestException}'
    if ('{valueOfDebugFetchRequest}' === '1') console.log('🟨 Fetch Request', url)
    
    if ('{fetchRequestExceptions}') {
        if ('{valueOfDebugRequestException}' === '1') console.log('🚫 Fetch Request Exception ', url)
        return false
    }
    if ('{valueOfDebugFetchRequest}' === '1') console.log('🟩 Fetch Request After Exception', url)

  e.respondWith(
  respondTo(e))
})



const setUpBadgeCount = async () => {
  if('setAppBadge' in navigator && 'clearAppBadge' in navigator) {
    const appBadgeCountForage = await getAppBadgeCount()
    const count = (appBadgeCountForage === 0) ? 1 : appBadgeCountForage + 1   
    navigator.setAppBadge(count)
    await localforage.setItem('appBadgeCount', count)
  }
}

const setUpBadgeUrls = async url => {
  if('setAppBadge' in navigator && 'clearAppBadge' in navigator) {
    const appBadgeUrlsForage = await getAppBadgeUrls()
    if (url === undefined) return
    const urlArrayForage = (appBadgeUrlsForage === null) ? [] : appBadgeUrlsForage  
    urlArrayForage.push(url)
    await localforage.setItem('appBadgeUrls', urlArrayForage)
  }
}


const checkConnection = async _ => {
  if ('connection' in navigator) {
    const network = await navigator.connection.type
    const connection = await navigator.connection.effectiveType
    if ('{valueOfDebugMode}' === '1') console.log('connection', connection)
    if (network === 'wifi' || connection === '4g') return true
  }
}

const checkStoragePersist = async _ => {
  if (navigator.storage && navigator.storage.persist) {
    const isPersisted = await navigator.storage.persist();
    return isPersisted
  }
}

const checkStorageAvailable = async _ => {
  if (navigator.storage && navigator.storage.estimate) {
    const quota = await navigator.storage.estimate();
    const percentageUsed = (quota.usage / quota.quota) * 100;
    if ('{valueOfDebugMode}' === '1') console.log(`You've used ${percentageUsed}% of the available storage.`);
    return percentageUsed
  }
}

const syncPages = async e => {
  if ('{valueOfDebugMode}' === '1') console.log('Periodic Sync is running')

  const connectionQuality = await checkConnection()
  if (!connectionQuality) return

  const storageMount = await checkStorageAvailable()
  if (storageMount > 80) return

  try {
    const pageUrls = ['{periodicSyncPages}']
    for (const url of pageUrls) {
      const response = await fetch(url)
      const cache = await self.caches.open(pageCacheName)
      cache.add(url, response.clone())
    }
  } catch (e) {
    console.log('errorSyncPage', e)
  }
}

const syncImages = async e => {
  if ('{valueOfDebugMode}' === '1') console.log('Periodic Sync is running')

  const connectionQuality = await checkConnection()
  if (!connectionQuality) return

  const storageMount = await checkStorageAvailable()
  if (storageMount > 80) return

  try {
    const imageUrls = ['{periodicSyncImages}']

    for (const url of imageUrls) {
      const response = await fetch(url)
      const cache = await self.caches.open(imgCacheName)
      cache.add(url, response.clone())
    }
  } catch (e) {
    console.log('errorSyncImg', e)
  }
}

self.addEventListener('periodicsync', e => {
  if (e.tag === 'page-sync') {
    e.waitUntil(syncPages(e))
  }

  if (e.tag === 'image-sync') {
    e.waitUntil(syncImages(e))
  }
})

self.addEventListener('message', (event) => {
  const isARefresh = (event) => event.data.message === 'refresh'

  const sendRefreshCompletedMessageToClient = (event) => event.ports[0].postMessage({refreshCompleted: true})

  if (isARefresh(event)) {
    if (navigator.onLine) cleanCacheVersion()
    sendRefreshCompletedMessageToClient(event)  
  }
  console.log(event.data)
  if (event.data.message === 'appBadgeCount') {
    setUpBadgeCount()
    setUpBadgeUrls(event.data.url)
  }
})
