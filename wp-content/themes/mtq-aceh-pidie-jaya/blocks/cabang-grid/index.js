(function(){
  const { registerBlockType } = wp.blocks;
  const { __ } = wp.i18n;
  const { InspectorControls } = wp.blockEditor || wp.editor;
  const { PanelBody, RangeControl, SelectControl } = wp.components;

  registerBlockType('mtq/cabang-grid', {
    title: __('Cabang Lomba Grid', 'mtq-aceh-pidie-jaya'),
    icon: 'awards',
    category: 'widgets',
    attributes: {
      columns: { type: 'number', default: 3 },
      gap: { type: 'string', default: 'gap-6' }
    },
    edit: (props) => {
      const { attributes: { columns, gap }, setAttributes } = props;
      return (
        wp.element.createElement('div', {},
          wp.element.createElement(InspectorControls, {},
            wp.element.createElement(PanelBody, { title: __('Pengaturan Grid', 'mtq-aceh-pidie-jaya'), initialOpen: true },
              wp.element.createElement(RangeControl, {
                label: __('Kolom (desktop)', 'mtq-aceh-pidie-jaya'),
                value: columns,
                onChange: (val) => setAttributes({ columns: val }),
                min: 1,
                max: 4
              }),
              wp.element.createElement(SelectControl, {
                label: __('Gap', 'mtq-aceh-pidie-jaya'),
                value: gap,
                options: [
                  { label: 'Kecil (gap-4)', value: 'gap-4' },
                  { label: 'Sedang (gap-6)', value: 'gap-6' },
                  { label: 'Besar (gap-8)', value: 'gap-8' }
                ],
                onChange: (val) => setAttributes({ gap: val })
              })
            )
          ),
          wp.element.createElement('div', { className: 'mtq-cabang-grid-placeholder' },
            __('Cabang Lomba Grid (pratinjau di front-end)', 'mtq-aceh-pidie-jaya')
          )
        )
      );
    },
    save: () => null
  });
})();
