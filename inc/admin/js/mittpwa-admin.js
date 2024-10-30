

window.addEventListener('DOMContentLoaded', e => {
	console.log('⚙️ miTT PWA Admin JS loaded ✅')

	const mittPwaAdminForm = document.querySelector('.mittpwaadminform')
	if (!mittPwaAdminForm)	return

	const showonFields = Array.from(document.querySelectorAll('.mitt_pwa_select_showon'))
	
	showonFields.forEach(field => {
		
		if (field.value === '2' 
				|| field.value === 'cachefirst' 
				|| field.value === 'alert_pop_up') 
				field.parentElement.parentElement.nextElementSibling.setAttribute('hidden', 'hidden')	

		if (field.name === 'mittpwawp_options[start_url]' 
		&& field.value !== 'custom_start_url') {
			field.parentElement.parentElement.nextElementSibling.setAttribute('hidden', 'hidden')	
		}

		
	
	})

	const showonFieldRegisterElements = document.querySelectorAll('.mitt_pwa_select_showon_sync_register')
	const showonFieldRegister = (field) => {
		[...showonFieldRegisterElements].forEach(element => {
			if(element.value === '1'){
				element.parentElement.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.setAttribute('hidden', 'hidden')		
				element.parentElement.parentElement.nextElementSibling.nextElementSibling.removeAttribute('hidden')		
				element.parentElement.parentElement.nextElementSibling.removeAttribute('hidden')	
				} else{
				
				element.parentElement.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.removeAttribute('hidden')
				
				element.parentElement.parentElement.nextElementSibling.nextElementSibling.setAttribute('hidden', 'hidden')	
				element.parentElement.parentElement.nextElementSibling.setAttribute('hidden', 'hidden')	
			}
		})
	}

	
	if (showonFieldRegisterElements.length > 0){
		showonFieldRegister(showonFieldRegisterElements)
	}
	

	const showonFieldUnregisterElements = document.querySelectorAll('.mitt_pwa_select_showon_sync_unregister')

	const showonFieldUnregister = (field) => {
		[...showonFieldUnregisterElements].forEach(element => {
			if(element.value === '1'){
				element.parentElement.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.setAttribute('hidden', 'hidden')	
				element.parentElement.parentElement.previousElementSibling.setAttribute('hidden', 'hidden')	
				
				} else{
			
				element.parentElement.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.removeAttribute('hidden')
				//element.parentElement.parentElement.previousElementSibling.removeAttribute('hidden')
			}
		})
	}

	if (showonFieldUnregisterElements.length > 0) {
		//showonFieldUnregister(showonFieldUnregisterElements)
	}



	const showonFieldFolder = document.querySelector('.mitt_pwa_select_showon_folder')
	const mittPwaFolderElements = document.querySelectorAll('.mitt_pwa_folder')

	const showhideFolderElements = (folderElements, selectValue) => {
		[...folderElements].forEach(element => {
			if(selectValue === '1'){
				element.parentElement.parentElement.setAttribute('hidden', 'hidden')
				} else{
				element.parentElement.parentElement.removeAttribute('hidden')
			}
		})
	}

	if (mittPwaFolderElements.length > 0) {
		showhideFolderElements(mittPwaFolderElements, showonFieldFolder.value)
	}



	const getfieldName = (target) => {
		const parent = target.parentElement.parentElement
		const description = parent.querySelector('.description')
		const previousElement = description.previousElementSibling
		const fieldName = previousElement.children[0].classList[0]
		return fieldName
	}

	const addInputFieldMittPwa = (target) => {
		const fragment = document.createDocumentFragment()
		const parent = target.parentElement.parentElement
		const description = parent.querySelector('.description')
		const previousElement = description.previousElementSibling
		const dataCount = previousElement.children[0].dataset.count 
		const fieldName = getfieldName(target)
		const counter = parseInt(dataCount) + 1

		const input = document.createElement('input')
		input.setAttribute('type', 'text')
		input.setAttribute('name', `mittpwawp_options[${fieldName}][${counter}]`)
		input.setAttribute('id', `mittpwawp_options_${fieldName}_${counter}`)
		input.setAttribute('data-count', counter)
		input.setAttribute('class', fieldName)
		input.setAttribute('value', '') // this field is used for different input fields

		const spanMinus = document.createElement('span')
		spanMinus.setAttribute('class', 'mittPwaRemove')
		spanMinus.innerHTML = `<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><title>minus</title><path d="M0 13v6c0 0.552 0.448 1 1 1h30c0.552 0 1-0.448 1-1v-6c0-0.552-0.448-1-1-1h-30c-0.552 0-1 0.448-1 1z"></path></svg>`

		const inputContainer = document.createElement('div')
		inputContainer.setAttribute('class', 'mittPwaInputContainer')
		inputContainer.appendChild(input)
		inputContainer.appendChild(spanMinus)
		fragment.appendChild(inputContainer)
		parent.insertBefore(fragment, description)
	}

	
	const getLabelNames = (target) => {
		const parent = target.parentElement.parentElement.children[0]
		const labelNamesArray = parent.querySelectorAll('label')
		const listNames = Array.from(labelNamesArray) 
		const labelNames = listNames.map(name => {	
			return name.innerText
		})
		return labelNames
	}

	const getFieldNames = (target, counter) => {
		const parent = target.parentElement.parentElement
		let fieldNamesArray = parent.querySelectorAll('input')
		if (fieldNamesArray.length === 0) {
			fieldNamesArray = parent.querySelectorAll('select')
		}
		const selectNamesArray = parent.querySelectorAll('select')
		const listNames = Array.from(fieldNamesArray)

		const mergedArray = [...listNames, ...selectNamesArray]
		const fieldNames = mergedArray.map(name => {
			return name.getAttribute('name')
		})
		const nextFieldNames = fieldNames.map(name => {
			return name.replace('[0]', `[${counter}]`)
		})
		return nextFieldNames
	}

	const getFieldUpload = (target) => {
		const parent = target.parentElement.parentElement
		const labelNamesArray = parent.querySelectorAll('label')
		const buttonFieldUploadOject = {}
		let counter = 0
		labelNamesArray.forEach(element => {
			if(element.nextElementSibling.nextElementSibling) {
				const buttonFieldUpload = element.nextElementSibling.nextElementSibling
				buttonFieldUploadOject[counter] = buttonFieldUpload.cloneNode(true)
			}
			counter++
		})
		return buttonFieldUploadOject
	}

	const getFieldSelect = (target, counter) => {
		const parent = target.parentElement.parentElement.children[0]
		const labelNamesArray = parent.querySelectorAll('label')
		
		const selectfieldOject = {}
		let count = 0
		labelNamesArray.forEach(element => {
			if(element.nextElementSibling.tagName === 'SELECT') {
				const selectField = element.nextElementSibling
				const selectName = selectField.getAttribute('name')
				const selectNewName = selectName.replace('[0]', `[${counter}]`)
				selectfieldOject[count] = selectField.cloneNode(true)
				selectfieldOject[count].setAttribute('name', selectNewName)
				selectfieldOject[count].setAttribute('data-count', counter)
			}
			count++
		})
		return selectfieldOject
	}


	const addLabelForInputFieldMittPwa = (target) => {
		const fragment = document.createDocumentFragment()
		const label = document.createElement('label')
		const fieldName = getfieldName(target)
		label.setAttribute('for', `mittpwafirepushwp_options[${fieldName}][${counter}]`)
		label.textContent = 'App Shortcut Name'
	}


	const labelMultipleFields = (target, element, fieldNames, counterFieldnames,  divLabelInput) => {
		const label = document.createElement('label')
		label.setAttribute('for', `${fieldNames[counterFieldnames]}]`)
		label.textContent = element
		divLabelInput.appendChild(label)
	}

	const getItemClass = (target) => {
		const parent = target.parentElement.parentElement
		const itemClass = parent.querySelector('input')
		const selectClass = parent.querySelector('select')
		if (itemClass) {
			return itemClass.getAttribute('class')
		} else if (selectClass) {
			return selectClass.getAttribute('class')
		} 
		return ''
	}


	const addInputFieldMittPwaShortcutItems = (target) => {
		const fragment = document.createDocumentFragment()
		const parent = target.parentElement.parentElement
		
		const description = parent.querySelector('.description')
		const previousElement = description.previousElementSibling
		const dataCount = previousElement.children[0].children[1].dataset.count
		const counter = parseInt(dataCount) + 1
		const labelNames = getLabelNames(target)

		const fieldNames = getFieldNames(target, counter)

		const spanMinus = document.createElement('span')
		spanMinus.setAttribute('class', 'mittPwaRemove')
		spanMinus.innerHTML = `<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><title>minus</title><path d="M0 13v6c0 0.552 0.448 1 1 1h30c0.552 0 1-0.448 1-1v-6c0-0.552-0.448-1-1-1h-30c-0.552 0-1 0.448-1 1z"></path></svg>`

		const inputContainer = document.createElement('div')
		inputContainer.setAttribute('class', 'mittPwaInputContainer')
		
		let counterFieldnames = 0
		const fieldUpload = getFieldUpload(target, counter)
		
		const selectElement = getFieldSelect(target, counter)
		const counterLabels = 0
		labelNames.forEach(element => {
			const divLabelInput = document.createElement('div')
			divLabelInput.setAttribute('class', 'mittpwa_label_input')

			const labelField = labelMultipleFields(target, element, fieldNames, counterFieldnames,  divLabelInput)
			const input = document.createElement('input')
			input.setAttribute('type', 'text')
			input.setAttribute('name', `${fieldNames[counterFieldnames]}]`)
			input.setAttribute('id', `${fieldNames[counter]}`)
			input.setAttribute('data-count', counter)
			input.setAttribute('class', getItemClass(target))
			
			if ( !selectElement[counterFieldnames]) {
				divLabelInput.appendChild(input)
				inputContainer.appendChild(divLabelInput)
			} 
			
			if(selectElement[counterFieldnames]){
				inputContainer.appendChild(divLabelInput)
				divLabelInput.appendChild(selectElement[counterFieldnames])		
			} 
			
			if (fieldUpload[counterFieldnames]){
				divLabelInput.appendChild(input)
				divLabelInput.appendChild(fieldUpload[counterFieldnames])
				inputContainer.appendChild(divLabelInput)
			}
			counterFieldnames++
		})
		inputContainer.appendChild(spanMinus)
		fragment.appendChild(inputContainer)
		parent.insertBefore(fragment, description)
	}

		mittPwaAdminForm.addEventListener('click', e => {
			
			const target = e.target

			if (target.closest('.mittPwaAddNew')){
				e.preventDefault()
				addInputFieldMittPwa(target)
			}

			if (target.closest('.mittPwaAddNewShortcutItems')){
				e.preventDefault()
				addInputFieldMittPwaShortcutItems(target)		
			}
			
			if (target.closest('.mittPwaRemove')){
				e.preventDefault()
				const parent = target.closest('.mittPwaRemove').parentElement
				parent.remove()
			}

			if (target.closest('.mittpwa_icon_upload')){
		
				e.preventDefault()
				const button = this;
				const mittPwaMediaUploader = wp.media({
					title: 'Icon for the shortcut',
					library: {
						type: 'image'
					},
					button: {
						text: 'Select Icon'
					},
					multiple: false
				})
				.on('select', function() {
					const attachment = mittPwaMediaUploader.state().get('selection').first().toJSON();
					const inputFieldUpload = target.previousElementSibling
					inputFieldUpload.value = attachment.url;
				})
				.open();
			}
			if (target.closest('.mittpwa_icons_upload')){
		
				e.preventDefault()
				const button = this;
				const mittPwaMediaUploader = wp.media({
					title: 'Icon for the shortcut',
					library: {
						type: 'image'
					},
					button: {
						text: 'Select Icon'
					},
					multiple: true
				})
				.on('select', function() {
					const attachment = mittPwaMediaUploader.state().get('selection').toJSON();
					const urls = attachment.map(item => item.url)
					const inputFieldUpload = target.previousElementSibling
					inputFieldUpload.value = urls;
				})
				.open();
			}
		})
	
	
	mittPwaAdminForm.addEventListener('change', e => {
		const target = e.target
		console.log('changeListener ⚙️')
		if (target.closest('.mitt_pwa_select_showon')){
			const selectValue = target.value
			const parent = target.parentElement.parentElement.nextElementSibling
			if (selectValue === '2' 
				|| selectValue === 'cachefirst' 
				|| selectValue === 'alert_pop_up'){
				parent.setAttribute('hidden', 'hidden')
			} else if (
				selectValue === 'custom_start_url'
				|| selectValue === '1'
				|| selectValue === 'networkfirst'
				|| selectValue === 'custom_alert_page'){
				parent.removeAttribute('hidden')
			}
		}

		if (target.closest('.mitt_pwa_select_showon_folder')){
			const selectValue = target.value
			if (mittPwaFolderElements.length > 0){
				showhideFolderElements(mittPwaFolderElements, selectValue)
			}
		}

		if (target.closest('.mitt_pwa_select_showon_sync_register')){
			const selectValue = target.value
			if (showonFieldRegisterElements.length > 0){
				showonFieldRegister(showonFieldRegisterElements)
			}
		}

		if (target.closest('.mitt_pwa_select_showon_sync_unregister')){
			const selectValue = target.value
			if (showonFieldUnregisterElements.length > 0){
				showonFieldUnregister(showonFieldUnregisterElements)
			}
		}
	})

	// Section Tabs

	const tableSections = mittPwaAdminForm.querySelectorAll('table')
	let count = 1
	const tableSectionsHider = (sections) => {
		sections.forEach(element => {
			element.setAttribute('hidden', 'hidden')
			element.previousElementSibling.setAttribute('hidden', 'hidden')
			element.previousElementSibling.previousElementSibling.style.display = 'none'
		})
	}

	tableSectionsHider(tableSections)

	const generalFields = document.querySelector('#mittpwawp_section_general').nextElementSibling 
	const cacheFields = document.querySelector('#mittpwawp_section_cache').nextElementSibling 
	const manifestFields = document.querySelector('#mittpwawp_section_manifest').nextElementSibling 
	const pushNotificationFields = document.querySelector('#mittpwawp_section_push_notification').nextElementSibling 
	const firebaseFields = document.querySelector('#mittpwawp_section_firebase_settings').nextElementSibling 
	const syncFields = document.querySelector('#mittpwawp_section_sync').nextElementSibling 
	const statisticFields = document.querySelector('#mittpwawp_section_statistic').nextElementSibling 
	const updateFields = document.querySelector('#mittpwawp_section_update').nextElementSibling 
	const changelogFields = document.querySelector('#mittpwawp_section_changelog').nextElementSibling

	const sectionHelperActiveTab = (showfield) => {
		const arraySections = [generalFields, cacheFields, manifestFields, pushNotificationFields, firebaseFields, syncFields, statisticFields, updateFields, changelogFields]
		tableSectionsHider(tableSections)
		showfield.removeAttribute('hidden')
	}

	const sectionHelper = (showfield, target) => {
		const arraySections = [generalFields, cacheFields, manifestFields, pushNotificationFields, firebaseFields, syncFields, statisticFields, updateFields, changelogFields]
		tableSectionsHider(tableSections)
		showfield.removeAttribute('hidden')
		const activeTabInputField = document.querySelector('#active_tab')
		const activeTab = (target) ? target.parentElement.dataset.tab : 'general'	
		activeTabInputField.value = activeTab

	}
	// loading the general section standard
	const activeTabInputField = document.querySelector('#active_tab')
	console.log('activeTabInputField', activeTabInputField)
	const activeTab = activeTabInputField.value
	const navTabs = document.querySelector('.mittpwawp_nav_tabs')
	

	if (activeTab === 'general'){
		sectionHelperActiveTab(generalFields)	
		navTabs.children[0].classList.add('active')
	}

	if (activeTab === 'cache'){
		sectionHelperActiveTab(cacheFields)
		navTabs.children[1].classList.add('active')
	}

	if (activeTab === 'manifest'){
		sectionHelperActiveTab(manifestFields)
		navTabs.children[2].classList.add('active')
	}

	if (activeTab === 'pushNotification'){
		sectionHelperActiveTab(pushNotificationFields)
		navTabs.children[3].classList.add('active')
	}

	if (activeTab === 'firebase'){
		sectionHelperActiveTab(firebaseFields)
		navTabs.children[4].classList.add('active')
	}

	if (activeTab === 'sync'){
		sectionHelperActiveTab(syncFields)
		navTabs.children[5].classList.add('active')
	}

	if (activeTab === 'statistic'){
		sectionHelperActiveTab(statisticFields)
		navTabs.children[6].classList.add('active')
	}

	if (activeTab === 'update'){
		sectionHelperActiveTab(updateFields)
		navTabs.children[7].classList.add('active')
	}

	if (activeTab === 'changelog'){
		sectionHelperActiveTab(manifestFields)
		navTabs.children[2].classList.add('active')
	}

	navTabs.addEventListener('click', e => {
	
		const target = e.target
		if (target.closest('.mittpwawp_nav_tab')){
			e.preventDefault()
			const tab = target.closest('.mittpwawp_nav_tab')
			const tabId = tab.dataset.tab
			const tabs = document.querySelectorAll('.mittpwawp_nav_tab')
			tabs.forEach(element => {
				element.classList.remove('active')
			})
			tab.classList.add('active')
			if (tabId === 'general'){			
				sectionHelper(generalFields, target)
			}
			if (tabId === 'cache'){
				sectionHelper(cacheFields, target)
			}
			if (tabId === 'manifest'){
				sectionHelper(manifestFields, target)
			}
			if (tabId === 'pushNotification'){
				sectionHelper(pushNotificationFields, target)
			}
			if (tabId === 'firebase'){
				sectionHelper(firebaseFields, target)
			}
			if (tabId === 'sync'){
				sectionHelper(syncFields, target)
			}
			if (tabId === 'statistic'){
				sectionHelper(statisticFields, target)
			}
			if (tabId === 'update'){
				sectionHelper(updateFields, target)
			}
			if (tabId === 'changelog'){
				sectionHelper(changelogFields, target)
			}
		}
	})
	
	
})

jQuery(document).ready(function() {
	jQuery('.color-picker').wpColorPicker();
});